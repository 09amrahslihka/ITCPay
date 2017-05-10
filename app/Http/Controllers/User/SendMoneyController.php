<?php

namespace App\Http\Controllers\User;

use App\Accounts;
use App\Balance;
use App\Business;
use App\Cards;
use App\Http\Controllers\Controller;
use App\Profile;
use App\Transactions;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SendMoneyController extends Controller
{

    /**
     * sendmoneyView
     *
     * action method to generate "send payment" page
     * modified Aug 26, 2016 Calculate available balance for the view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function sendmoneyView()
    {
        if (!Auth::User()->active == "1" && Auth::User()->tmp_email == "") {
            $email = Auth::User()->email;
            $accountType = Auth::User()->account_type;
            if ($accountType == 'business') {
                $businessData = Business::where('user_id', '=', Auth::User()->id)->first();
                $profile = $businessData->name;
            } else {
                $personalData = Profile::find(Auth::User()->id);
                $profile = $personalData->fname . "&nbsp;" . $personalData->mname . "&nbsp;" . $personalData->lname;
            }
            return view('User.confirmation.verifyLoggedInUser', compact("email", "profile"));
        }
        $accounts = Accounts::where('user_id', '=', Auth::user()->id)->where('is_removed', '=', 0)->get();
        $cards = cards::where('user_id', '=', Auth::user()->id)->where('status', '=', '2')->get();
        $title = "Send payment";
        $balance = Balance::find(Auth::user()->id);
        //fetch pending balance
        $pendingBalance = Transactions::where('user_id', '=', Auth::user()->id)->where('ptype', '=', 3)->where('status', '=', 'Under Processing')->sum('netamount');
        $availableBalance = $balance->balance - $pendingBalance;
        $formattedAvailableBalance = ($availableBalance >= 0 ? "$" : "-$") . number_format(abs($availableBalance), 2);
        $ownEmail = Auth::user()->email;
        return view('User.dashboard.sendmoney.sendmoney', compact('accounts', 'cards', 'title', 'formattedAvailableBalance', 'availableBalance', 'ownEmail'));
    }

    /**
     * verifySendEmail
     *
     * action method to verify send email exists or not
     * created Aug 26, 2016
     *
     * @param Request $request Http Request Object
     * @return Response Http JSON Response Object
     * @author NA
     */
    public function verifySendEmail(Request $request)
    {
        return response()->json(boolval(User::where('email', '=', $request->input('email'))->where('id', '!=', Auth::user()->id)->count()));
    }

    /**
     * fetchFeeAndTotalAmount
     *
     * action method to calculate amount fee and total amount
     * created Aug 26, 2016
     *
     * @param Request $request Http Request Object
     * @return Response Http JSON Response Object
     * @author NA
     */
    public function fetchFeeAndTotalAmount(Request $request)
    {
        $fee = floatval($request->input('sendAmountTxt')) * $this->_getFeeMultiplier($request);
        return response()->json([
            'fee' => round($fee, 2),
            'totalCost' => round(floatval($request->input('sendAmountTxt')) + $fee, 2)
        ]);
    }

    /**
     * _getFeeMultiplier
     *
     * method to get a fee multiplier for send amount to calculate fee
     * created Aug 26, 2016
     *
     * @param Request $request Http Request Object
     * @return float|int
     *
     * @author NA
     */
    private function _getFeeMultiplier(Request $request)
    {
        $paymentScope = $this->_getPaymentScope($request);
        switch ($request->input('paymentTypeSlct')) {
            case 1: //Personal payments (payments to friends and family)
                switch ($paymentScope) {
                    case "domestic": //Domestic payments
                        return 0; //with account balance
                    case "international": //International Payments
                        return 0.02; //with account balance
                }
            case 2: //Payments for goods or services
                switch ($paymentScope) {
                    case "domestic": //Domestic payments
                        return 0; //with account balance
                    case "international": //International Payments
                        return 0.02; //with account balance
                }
        }
        return 0;
    }

    /**
     * _getReceiverFeeMultiplier
     *
     * method to get receiver fee multiplier for payment received
     * created Aug 26, 2016
     *
     * @param Request $request Http Request Object
     * @return float|int
     *
     * @author NA
     */
    private function _getReceiverFeeMultiplier(Request $request)
    {
        switch ($request->input('paymentTypeSlct')) {
            case 1: //Personal payments (payments to friends and family)
                return 0;
            case 2: //Payments for goods or services
                return 0.03;
        }
        return 0;
    }

    /**
     * _getPaymentScope
     *
     * method to get payment scope i.e. domestic/international
     * created Aug 26, 2016
     *
     * @param Request $request Http Request Object
     * @return string
     * @author NA
     */
    private function _getPaymentScope(Request $request)
    {
        $currentUser = DB::table('users')
            ->leftJoin('profile', 'profile.id', '=', 'users.id')
            ->leftJoin('business', 'business.user_id', '=', 'users.id')
            ->select('users.account_type', DB::raw('profile.country AS profile_country'), DB::raw('business.country AS business_country'))
            ->where('users.id', '=', Auth::user()->id)
            ->first();
        $targetUser = DB::table('users')
            ->leftJoin('profile', 'profile.id', '=', 'users.id')
            ->leftJoin('business', 'business.user_id', '=', 'users.id')
            ->select('users.account_type', DB::raw('profile.country AS profile_country'), DB::raw('business.country AS business_country'))
            ->where('users.email', '=', $request->input('emailTxt'))
            ->first();

        return $currentUser->profile_country == $targetUser->profile_country ? "domestic" : "international";
    }

    /**
     * sendMoney
     *
     * action method to send money
     * created Aug 26, 2015 Optimized old sendMoney method with only money from account
     * removed existing logic and wrote optimized new logic
     * old sendmoney action method scrubbed off to avoid confusion for future developers
     *
     * @param Request $request Http Request Object
     * @author NA
     */
    public function sendmoney(Request $request)
    {
        $feeAndTotal = $this->fetchFeeAndTotalAmount($request);
        $senderFee = floatval($request->input('sendAmountTxt')) * $this->_getFeeMultiplier($request);
        $senderTotalCost = floatval($request->input('sendAmountTxt')) + $senderFee;

        $receiver = \App\User::where('email', $request->input('emailTxt'))->first();

        //fetch current balance
        $senderBalanceEntity = \App\Balance::find(Auth::user()->id);
        $senderCurrentBalance = $senderBalanceEntity->balance;
        $receiverBalanceEntity = \App\Balance::find($receiver->id);
        $receiverCurrentBalance = $receiverBalanceEntity->balance;

        $receiverFee = floatval($request->input('sendAmountTxt')) * $this->_getReceiverFeeMultiplier($request);
        $receiverTotalAmount = floatval($request->input('sendAmountTxt')) - $receiverFee;

        $senderFinalBalance = $senderCurrentBalance - $senderTotalCost;
        $receiverFinalBalance = $receiverCurrentBalance + $receiverTotalAmount;

        $senderUserProfile = Profile::Where('id', '=', Auth::user()->id)->first();

        $transaction_id = strtoupper(str_random(20));
        $receiverName = $this->_getReceiverName($receiver);

        $senderTransaction = new \App\Transactions();
        $senderTransaction->user_id = Auth::user()->id;
        $senderTransaction->transaction_id = $transaction_id;
        $senderTransaction->type = $request->input('paymentTypeSlct');
        $senderTransaction->ptype = '1';
        $senderTransaction->name = $receiverName;
        $senderTransaction->status = 'Completed';
        $senderTransaction->gross = $request->input('sendAmountTxt');
        $senderTransaction->fee = $senderFee;
        $senderTransaction->netamount = $senderTotalCost;
        $senderTransaction->balance = $senderFinalBalance;
        $senderTransaction->from = Auth::user()->email;
        $senderTransaction->to = $receiver->email;
        $senderTransaction->message = $request->input('messageTxt');
        $senderTransaction->save();

        //update sender balance
        $senderBalanceEntity->balance = $senderFinalBalance;
        $senderBalanceEntity->save();

        $receiverTransaction = new \App\Transactions();

        $receiverTransaction->user_id = $receiver->id;
        $receiverTransaction->transaction_id = $transaction_id;
        $receiverTransaction->type = $request->input('paymentTypeSlct');
        $receiverTransaction->ptype = '2';
        $receiverTransaction->name = $this->_getSenderName(); //should show sender's name
        $receiverTransaction->status = 'Completed';
        $receiverTransaction->gross = $request->input('sendAmountTxt');
        $receiverTransaction->fee = $receiverFee;
        $receiverTransaction->netamount = $receiverTotalAmount;
        $receiverTransaction->balance = $receiverFinalBalance;
        $receiverTransaction->from = Auth::user()->email;
        $receiverTransaction->to = $receiver->email;
        $receiverTransaction->message = $request->input('messageTxt');
        $receiverTransaction->save();

        //update receiver balance
        $receiverBalanceEntity->balance = $receiverFinalBalance;
        $receiverBalanceEntity->save();

        return Redirect('send-payment')->with('message', $this->_getFlashMessage($request, $receiverName));
    }

    /**
     * _getFlashMessage
     *
     * method to get flash message to be displayed on successful transaction
     * created Aug 29, 2016
     *
     * @param Request $request
     * @param $receiverName
     * @return string
     *
     * @author NA
     */
    private function _getFlashMessage(Request $request, $receiverName)
    {
        return "You have successfully sent $" . $request->input('sendAmountTxt') . " to $receiverName.";
    }

    /**
     * _getReceiverName
     *
     * method to get receiver name based on type of transaction
     * try to fetch business name if exists
     * created Aug 26, 2016
     * modified Sep 2, 2016 As per client requirement receiver business name(if exists) must appear irrespective of payment type(personal/goods & services)
     *
     * @param Request $request
     * @param User $receiver
     * @return string
     *
     * @author NA
     */
    private function _getReceiverName(\App\User $receiver)
    {
        $receiverProfile = Profile::Where('id', '=', $receiver->id)->first();
        $receiverBusiness = Business::where('user_id', '=', $receiver->id)->first();
        if ($receiverBusiness) {
            return $receiverBusiness->name;
        }
        return $receiverProfile->fname . " " . $receiverProfile->lname;
    }

    /**
     * _getSenderName
     *
     * method to get sender name
     * created Sep 2, 2016 Will show business name(if exists) irrespective of payment type(personal/goods & services)
     *
     * @param Request $request
     * @param User $sender
     * @return string
     *
     * @author NA
     */
    private function _getSenderName()
    {
        $senderProfile = Profile::Where('id', '=', Auth::user()->id)->first();
        $senderBusiness = Business::where('user_id', '=', Auth::user()->id)->first();
        if ($senderBusiness) {
            return $senderBusiness->name;
        }
        return $senderProfile->fname . " " . $senderProfile->lname;
    }
}

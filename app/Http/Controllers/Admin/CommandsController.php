<?php

namespace App\Http\Controllers\Admin;

use App\Business;
use App\Commands;
use App\Http\Controllers\Controller;
use App\Profile;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CommandsController extends Controller
{

    public function listCommands()
    {
        $defaultLength = 25;
        return view('Admin.commands.list', compact('defaultLength'));
    }

    public function editCommand($id, Request $request)
    {

        $post = $request->all();
        $number = $post['number'];

        $command = Commands::find($id);

        if (!$command || !$number)
            return ['status' => 'error'];

        $command->value = $number;
        $command->save();

        return ['status' => 'ok', 'number' => $number];
    }

    public function listCommandsResult(Request $request)
    {
        $columns = $request->get('columns');
        $order = $request->get('order');
        $orderColumnNum = $order[0]['column'];
        $orderDir = $order[0]['dir'];
        $orderColumnName = $columns[$orderColumnNum]['name'];
        //$this->_persistLength($request);
        $query = \App\Commands::query();
        $this->_attachGlobalSearch($request, $query);
        $recordsTotal = $query->count();
        $filteredTotal = $recordsTotal;
        $commands = $query->orderBy($orderColumnName, $orderDir)
            ->skip($request->get('start'))
            ->take($request->get('length'))->get();

        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $filteredTotal,
            'data' => $commands->map(function ($command) use ($request) {
                return [
                    $command->name,
                    "<span data-id=\"{$command->id}\">{$command->value}</span>",
                    date('d M Y', strtotime($command->created_at)),
                    "<button class=\"btn btn-default\" onclick=editModal(\"$command->id\")>Edit number</button>"
                ];
            })
        ]);
    }

    /**
     * _attachGlobalSearch
     *
     * method to attach a global search keyword
     * created Sep 13, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _attachGlobalSearch(Request $request, $query)
    {
        $keyword = str_replace(",", "", trim($request->get('globalSearchTxt')));
        if (!empty($keyword)) {
            $stringPattern = $this->_getStringPattern($keyword);
            //apply string pattern
            if ($stringPattern) {
                $query->where(function ($query) use ($stringPattern) {
                    $query->where('commands.name', 'regexp', $stringPattern)
                        ->orWhere('commands.value', 'regexp', $stringPattern);
                });
            }

            $datePattern = $this->_getDatePattern($keyword);
            if ($datePattern) {
                $query->where('users.created_at', 'regexp', $datePattern);
            }
        }
    }

    /**
     * _getStringPattern
     *
     * method to get string regexp pattern for query
     * created Sep 13, 2016
     *
     * @param String $keyword global search keyword
     *
     * @return String Regex String Pattern
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _getStringPattern($keyword)
    {
        $extractedString = trim(preg_replace("/((0?[1-9])|([1-2][0-9])|(3[0-1])) (Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) [0-9]{4}/i", "", $keyword));
        $exploded = explode(" ", $extractedString);
        $combinations = [];
        $this->_fetchLinearCombinations(0, $exploded, $combinations);
        return implode("|", $combinations);
    }

    /**
     * _fetchLinearCombinations
     *
     * method to get linear combinations of string
     * created Sep 13, 2016
     *
     * @param int $from index to start the combination from
     * @param array $words array of words
     * @param array $combinations array to contain generation linear combinations
     *
     * @return void|false
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _fetchLinearCombinations($from, &$words, &$combinations = [])
    {
        if ($from == count($words))
            return false;

        $combinations[] = implode(" ", array_slice($words, $from, count($words)));
        $this->_fetchLinearCombinations($from + 1, $words, $combinations);
    }

    /**
     * _getDatePattern
     *
     * method to get string regexp pattern for dates supplied in global search string
     * created Sep 13, 2016
     *
     * @param String $keyword global search keyword
     *
     * @return array
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _getDatePattern($keyword)
    {
        $dateMatchRegex = "/((0?[1-9])|([1-2][0-9])|(3[0-1])) (Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) [0-9]{4}/i";
        $matches = [];
        preg_match_all($dateMatchRegex, $keyword, $matches);
        return array_map(function ($searchDate) {
            return date('Y-m-d', strtotime($searchDate));
        }, $matches[0]);
    }

    /**
     * _getName
     *
     * method to get user's business/personal name
     * created Sep 13, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _getName($user)
    {
        return $user->account_type == 'business' ? $user->business_name . "<br />(" . $user->fname . " " . $user->lname . ")" : $user->fname . " " . $user->lname;
    }

    /**
     * manageUser
     *
     * action method to manage user account
     * created Sep 13, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function manageUser(Request $request, $email = null)
    {
        $user = User::where('email', $email)->first();
        $profile = Profile::where('id', $user->id)->first();
        $business = Business::where('user_id', $user->id)->first();
        //check if card info is submitted by user and is waiting for approval
        $cardInfoSubmitted = boolval(\App\Cards::where('user_id', $user->id)->where('status', '2')->count());
        $personalInfoSubmitted = boolval(\App\VerificationInformation::where('user_id', $user->id)->where('type', 'personal')->where('is_saved', 1)->count());
        $businessInfoSubmitted = boolval(\App\VerificationInformation::where('user_id', $user->id)->where('type', 'business')->where('is_saved', 1)->count());
        return view('Admin.users.manage', compact('user', 'profile', 'business', 'cardInfoSubmitted', 'personalInfoSubmitted', 'businessInfoSubmitted'));
    }

    /**
     * verifySendEmail
     *
     * action method to verify send email exists or not
     * created Aug 26, 2016
     *
     * @param Request $request Http Request Object
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function verifySendEmail(Request $request)
    {
        return response()->json(boolval(\App\User::where('email', '=', $request->input('email'))->where('id', '!=', Auth::user()->id)->count()));
    }

    /**
     * verifyUserEmail
     *
     * action method to manually verify user email
     * created Sep 13, 2016
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function verifyUserEmail(Request $request)
    {
        $user = \App\User::where('email', $request->input('email'))->first();
        $user->active = "1";
        $user->confirmation_code = "";
        $user->tmp_email = "";
        $user->save();

        return response()->json([
            'error' => false,
            'message' => 'User email verified successfully!',
            'verified' => boolval($user->verify)
        ]);
    }

    /**
     * verifyUserAccount
     *
     * action method to manually verify user account
     * created Sep 13, 2016
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function verifyUserAccount(Request $request)
    {
        $user = \App\User::where('email', $request->input('email'))->first();
        $user->verify = "1";
        $user->save();

        return response()->json([
            'error' => false,
            'message' => 'User account verified successfully!'
        ]);
    }

    /**
     * addFunds
     *
     * action method to add funds to user account & available balance
     * created Sep 13, 2016
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function addFunds(Request $request)
    {
        $user = \App\User::where('email', $request->input('email'))->first();
        $balance = \App\Balance::where('id', $user->id)->first();

        $this->_makeAddFundsTransactionEntry($request->input('email'), $request->input('amountTxt'));

        if ($balance) {
            $balance->balance = $balance->balance + floatval(round($request->input('amountTxt'), 2));
            $balance->save();
        } else {
            $balance = new \App\Balance();
            $balance->id = $user->id;
            $balance->balance = floatval(round($request->input('amountTxt'), 2));
            $balance->save();
        }

        return response()->json([
            'error' => false,
            'message' => '$' . floatval(round($request->input('amountTxt'), 2)) . " added to account & available balance.",
        ]);
    }

    /**
     * _makeAddFundsTransactionEntry
     *
     * method to create dummy transaction for
     * created Sep 16, 2016
     *
     * @param $email
     * @param $gross
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _makeAddFundsTransactionEntry($email, $gross)
    {
        $receiver = \App\User::where('email', $email)->first();
        $receiverBalanceEntity = \App\Balance::find($receiver->id);
        $receiverCurrentBalance = $receiverBalanceEntity->balance;
        $transaction_id = strtoupper(str_random(20));

        $receiverFee = 0.00;
        $receiverTotalAmount = floatval($gross) - $receiverFee;
        $receiverFinalBalance = $receiverCurrentBalance + $receiverTotalAmount;
        $receiverTransaction = new \App\Transactions();

        $receiverTransaction->user_id = $receiver->id;
        $receiverTransaction->transaction_id = $transaction_id;
        $receiverTransaction->type = 0;
        $receiverTransaction->ptype = 4;
        $receiverTransaction->name = "Payment's Hub Administrator"; //should show sender's name
        $receiverTransaction->status = 'Completed';
        $receiverTransaction->gross = $gross;
        $receiverTransaction->fee = $receiverFee;
        $receiverTransaction->netamount = $receiverTotalAmount;
        $receiverTransaction->balance = $receiverFinalBalance;
        $receiverTransaction->from = Auth::user()->email;
        $receiverTransaction->to = $receiver->email;
        $receiverTransaction->message = "Funds added by Site Administrator";
        $receiverTransaction->save();

        //update receiver balance
        $receiverBalanceEntity->balance = $receiverFinalBalance;
        $receiverBalanceEntity->save();
    }

    /**
     * generateAuthPassword
     *
     * action method to generate/re-generate authorization password for the user
     * created Sep 13, 2016
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function generateAuthPassword(Request $request)
    {
        $user = \App\User::where('email', $request->input('email'))->first();
        $user->authorization_password = strtoupper(str_random(20));
        $user->save();

        return response()->json([
            'error' => false,
            'message' => 'User account verified successfully!',
            'authorizationPassword' => $user->authorization_password
        ]);
    }

    /**
     * cardAuthenticationInformation
     *
     * action method to authenticate added card
     * created Sep 13, 2016
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function userCards(Request $request, $email = null)
    {
        $user = \App\User::where('email', $email)->first();
        $cards = \App\Cards::where('user_id', $user->id)->where('status', '2')->get();
        return view('Admin.users.manage.information.cards', compact('user', 'cards', 'email'));
    }

    /**
     * cardAuthenticationInformationAndDocuments
     *
     * action method to display authentication information for added a particular card
     * created Sep 13, 2016
     *
     * @param Request $request
     * @param String $email route parameter containing email
     * @param String $cardId route parameter containing card ID
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function cardAuthenticationInformationAndDocuments(Request $request, $email = null, $cardId = null)
    {
        $card = \App\Cards::where('id', $cardId)->where('status', '2')->first();
        return view('Admin.users.manage.information.card-authentication', compact('user', 'email', 'card'));
    }

    /**
     * deleteCardInformation
     *
     * action method to delete card info
     * created Sep 14, 2016
     *
     * @param Request $request
     * @param null $cardId
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function deleteCardInformation(Request $request, $email = null, $cardId = null)
    {
        $card = \App\Cards::where('id', $cardId)->where('status', '2')->first();
        $card->status = "3";
        $card->id_type = "";
        $card->id_number = "";
        $card->issuing_authority = "";
        $card->expiry_date = "0000-00-00";
        $card->pan_card_number = "";
        $card->photo_id = "";
        $card->photo_name = "";

        $card->save();
        return Redirect::route('admin_users_manage', ['email' => $email])->with('message', 'Card information successfully deleted !');
    }

    /**
     * personalVerificationInformationAndDocuments
     *
     * action method to display personal verification information submitted by user
     * created Sep 13, 2016
     *
     * @param Request $request
     * @param String $email
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function personalVerificationInformationAndDocuments(Request $request, $email = null)
    {
        $user = \App\User::where('email', $email)->first();
        $personalInfo = \App\VerificationInformation::where('user_id', $user->id)->where('type', 'personal')->where('is_saved', 1)->first();
        $verificationDocument = \App\VerificationInformationDocuments::where('verification_id', $personalInfo->id)->first();
        return view('Admin.users.manage.information.personal', compact('user', 'personalInfo', 'verificationDocument'));
    }

    /**
     * deletePersonalVerificationInformation
     *
     * action method to delete personal verification info submitted by user
     * created Sep 14, 2016
     *
     * @param Request $request
     * @param null $cardId
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function deletePersonalVerificationInformation(Request $request, $email = null)
    {
        $user = \App\User::where('email', $email)->first();
        $personalInfo = \App\VerificationInformation::where('user_id', $user->id)->where('type', 'personal')->where('is_saved', 1)->first();

        $personalInfo->delete();
        return Redirect::route('admin_users_manage', ['email' => $email])->with('message', 'Personal verification information successfully deleted !');
    }

    /**
     * businessVerificationInformationAndDocuments
     *
     * action method to display business verification information submitted by user
     * created Sep 13, 2016
     *
     * @param Request $request
     * @param String $email
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function businessVerificationInformationAndDocuments(Request $request, $email = null)
    {
        $user = \App\User::where('email', $email)->first();
        $businessInfo = \App\VerificationInformation::where('user_id', $user->id)->where('type', 'business')->where('is_saved', 1)->first();
        $verificationDocument = \App\VerificationInformationDocuments::where('verification_id', $businessInfo->id)->first();
        return view('Admin.users.manage.information.business', compact('user', 'businessInfo', 'verificationDocument'));
    }

    /**
     * deleteBusinessVerificationInformation
     *
     * action method to delete personal verification info submitted by user
     * created Sep 14, 2016
     *
     * @param Request $request
     * @param null $cardId
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function deleteBusinessVerificationInformation(Request $request, $email = null)
    {
        $user = \App\User::where('email', $email)->first();
        $businessInfo = \App\VerificationInformation::where('user_id', $user->id)->where('type', 'business')->where('is_saved', 1)->first();

        $businessInfo->delete();
        return Redirect::route('admin_users_manage', ['email' => $email])->with('message', 'Business verification information successfully deleted !');
    }

    /**
     * deleteUserAccount
     *
     * action method to soft delete user records
     * created Sep 20, 2016
     *
     * @param Request $request
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function deleteUserAccount(Request $request)
    {
        \App\User::destroy(array_values($request->input('userIDs')));
        return response()->json([
            'error' => false,
            'message' => 'Select user account deleted successfully!'
        ]);
    }

    /**
     * deleteSuccessRedirect
     *
     * action method to redirect to users list page after successful delete
     * created Sep 20, 2016
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function deleteSuccessRedirect(Request $request)
    {
        return response()->redirectToRoute('admin_users_list')->with('message', $request->get('count') . ($request->get('count') == 1 ? " user" : " users") . ' successfully deleted!');
    }

    /**
     * deleteSuccessDashRedirect
     *
     * action method to redirect to dashboard after successful delete
     * created Sep 20, 2016
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function deleteSuccessDashRedirect(Request $request)
    {
        return response()->redirectToRoute('admin_dashboard')->with('message', $request->get('count') . ($request->get('count') == 1 ? " user" : " users") . ' successfully deleted!');
    }

}
        
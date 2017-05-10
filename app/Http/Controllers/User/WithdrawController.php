<?php

namespace App\Http\Controllers\User;

use App\Accounts;
use App\Balance;
use App\Business;
use App\Cards;
use App\Http\Controllers\Controller;
use App\Profile;
use App\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class WithdrawController extends Controller
{
    private $_bankWithdrawalFee;
    private $_withdrawTo;
    private $_account, $_card;
    private $_minimumWithdrawAmountCard = 20.00;
    private $_cardWithdrawalFee = 4.00;

    public function __construct()
    {
        $this->_bankWithdrawalFee = [];
        $this->_withdrawTo = array_flip(['bank_account', 'card']);
        $this->_account = $this->_card = null;
    }

    public function withdraw()
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
        $title = "Send payment";
        $accounts = Accounts::where('accounts.user_id', '=', Auth::user()->id)
            ->where('is_removed', '=', 0)
            ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
            ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.user_id', '=', 'accounts.user_id')
            ->select('accounts.*', 'account_verification_details.account_user_id', 'user_identity_verification_details.ssn')
            ->orderBy('accounts.is_primary', 'DESC')
            ->orderBy('accounts.id', 'ASC')->get();
        $accountsForDropdown = [];
        $accounts->map(function ($account) use (&$accountsForDropdown) {
            if (!($account->country == 'United States' && (empty($account->account_user_id) || empty($account->ssn)))) {
                $accountsForDropdown[$account->id] = [
                    'country' => $account->country,
                    'option' => $account->bank_name . "-" . $this->_formatSensitiveNumbers($account->account_number ?: $account->iban ?: $account->clabe)
                ];
            }
        });

        $cards = Cards::where('cards.user_id', '=', Auth::user()->id)
            ->where('is_removed', '=', 0)
            ->select('cards.*')
            ->orderBy('cards.id', 'ASC')->get();
        $cardsForDropdown = [];
        $cards->map(function ($card) use (&$cardsForDropdown) {
            $cardsForDropdown[$card->id] = [
                'option' => $card->type . ' ' . $this->_formatSensitiveNumbers($card->card_number)
            ];
        });

        $balance = Balance::find(Auth::user()->id);
        //fetch pending balance
        $pendingBalance = Transactions::where('user_id', '=', Auth::user()->id)->where('ptype', '=', 3)->where('status', '=', 'Under Processing')->sum('netamount');
        $availableBalance = $balance->balance - $pendingBalance;
        $formattedAvailableBalance = ($availableBalance >= 0 ? "$" : "-$") . number_format(abs($availableBalance), 2);
        $this->_loadMinimumBankWithdrawAmount();
        $minimumWithdrawAmounts = $this->_minimumWithdrawalAmounts;
        $bankWithdrawalFee = $this->_loadBankWithdrawalFee();
        $withdrawToOptions = ['bank_account' => 'Bank account', 'card' => 'Card'];

        $minimumWithdrawAmountCard = number_format($this->_minimumWithdrawAmountCard, 2);
        $cardWithdrawalFee = $this->_cardWithdrawalFee;

        $isCardWithdrawAvailable = $this->isCardWithdrawAvailable();

        return view('User.dashboard.withdraw.withdraw',
            compact('title', 'accountsForDropdown', 'cardsForDropdown', 'formattedAvailableBalance', 'availableBalance',
                'minimumWithdrawAmounts', 'minimumWithdrawAmountCard', 'isCardWithdrawAvailable',
                'bankWithdrawalFee', 'cardWithdrawalFee', 'withdrawToOptions'));
    }

    /**
     * _formatSensitiveNumbers
     *
     * method to format bank account and card numbers to hide sensitive information
     * created Aug 25, 2016
     *
     * @param $number
     * @return string
     */
    private function _formatSensitiveNumbers($number)
    {
        return strlen($number) - 4 > 0 ? str_repeat("*", strlen($number) - 4) . substr($number, -4) : str_repeat("*", strlen($number));
    }

    /**
     * _loadMinimumBankWithdrawAmount
     *
     * method to load minimum bank withdraw amount
     * created Aug 29, 2016
     *
     * @author NA
     */
    private function _loadMinimumBankWithdrawAmount()
    {
        $this->_minimumWithdrawalAmounts = [];
        $minimumWithdrawalAmounts = \App\MinimumWithdrawalAmounts::all();
        $minimumWithdrawalAmounts->each(function ($withdrawalAmountRecord) {
            $this->_minimumWithdrawalAmounts[$withdrawalAmountRecord->country] = $withdrawalAmountRecord->amount;
        });

        return $this->_minimumWithdrawalAmounts;
    }

    /**
     * _loadBankWithdrawalFee
     *
     * method to load bank withdrawal fee for all countries
     * created Aug 25, 2016
     *
     * @author NA
     * @return array country-wise fee array
     */
    private function _loadBankWithdrawalFee()
    {
        $this->_bankWithdrawalFee = [];
        $feesBankWithdrawal = \App\FeesBankWithdrawal::all();
        $feesBankWithdrawal->each(function ($feeRecord) {
            $this->_bankWithdrawalFee[$feeRecord->country] = $feeRecord->fee;
        });

        return $this->_bankWithdrawalFee;
    }

    /**
     * method get fee from db for account country
     * created Aug 25, 2016
     *
     * @param $withdrawTo string one of allowed withdrawal methods, currently supported: card, bank_account
     *
     * @return mixed
     * @author NA
     */
    private function _getFee($withdrawTo)
    {
        if ($withdrawTo == 'bank_account')
            $fee = isset($this->_bankWithdrawalFee[$this->_account->country]) ?
                $this->_bankWithdrawalFee[$this->_account->country] :
                $this->_bankWithdrawalFee['others'];
        else
            $fee = $this->_cardWithdrawalFee;

        return $fee;
    }

    /**
     * _getTransactionName
     *
     * method to get transaction name
     * Bank:
     * <Bank Name>
     * <Account Number>
     * Card:
     * <Card Type>
     * <Card Number>
     * All in JSON Format
     * created Aug 25, 2016
     *
     * @author NA
     *
     * @param $withdrawTo
     *
     * @return string
     */
    private function _getTransactionName($withdrawTo)
    {
        if ($withdrawTo == 'bank_account')
            $name = json_encode([
                'bankName' => $this->_account->bank_name,
                'accountNumber' => $this->_account->account_number ?: $this->_account->iban ?: $this->_account->clabe
            ]);
        else
            $name = json_encode([
                'cardType' => $this->_card->type,
                'cardNumber' => $this->_formatSensitiveNumbers($this->_card->card_number)
            ]);

        return $name;
    }

    /**
     * _getWithdrawID
     *
     * method to get account id or card id based on type of withdraw
     * created Aug 25, 2016
     *
     * @author NA
     *
     * @param $withdrawTo
     *
     * @return
     */
    private function _getWithdrawID($withdrawTo)
    {
        if ($withdrawTo == 'bank_account')
            return $this->_account->id;
        else
            return $this->_card->id;
    }

    /**
     * withdrawmoney
     *
     * action method to process withdrawal request
     * modified Aug 25, 2016
     *
     * @return mixed
     * @author NA
     */
    public function withdrawmoney(Request $request)
    {
        $withdrawTo = Input::get('withdrawToSlct');

        if ($withdrawTo == 'card' && !$this->isCardWithdrawAvailable())
            \App::abort(400);

        $allowedWithdrawTo = array('card', 'bank_account');
        if (!in_array($withdrawTo, $allowedWithdrawTo))
            $withdrawTo = 'bank_account';

        if ($withdrawTo == 'bank_account')
            $this->_loadBankWithdrawalFee();


        $amount = Input::get('withdrawAmountTxt');
        $balance = Balance::find(Auth::user()->id);
        //fetch pending balance
        $pendingBalance = Transactions::where('user_id', '=', Auth::user()->id)->where('ptype', '=', 3)->
        where('status', '=', 'Under Processing')->sum('netamount');
        $availableBalance = $balance->balance - $pendingBalance;

        if ($withdrawTo == 'bank_account')
            $this->_account = \App\Accounts::find(Input::get('accountSlct'));
        else
            $this->_card = \App\Cards::find(Input::get('cardSlct'));

        $netammount = Input::get('withdrawAmountTxt') + $this->_getFee($withdrawTo);

        if ($availableBalance >= $netammount) {
            //create a transaction
            $transaction = new Transactions();
            $transaction->transaction_id = strtoupper(str_random(20));
            $transaction->user_id = Auth::user()->id;
            $transaction->type = 0;
            $transaction->ptype = 3;
            $transaction->name = $this->_getTransactionName($withdrawTo);
            $transaction->status = 'Under Processing';

            $transaction->gross = Input::get('withdrawAmountTxt');
            $transaction->fee = $this->_getFee($withdrawTo);
            $transaction->netamount = Input::get('withdrawAmountTxt') + $this->_getFee($withdrawTo);
            $transaction->balance = $balance->balance;

            $transaction->withdraw_to = $withdrawTo == 'bank_account' ? 1 : 2;
            $transaction->withdraw_id = $this->_getWithdrawID($withdrawTo);
            $transaction->save();
            return Redirect('withdraw-money')->with('message', 'Your withdrawal request has been submitted and your withdrawal is under processing.');
        } else {
            return Redirect('withdraw-money')->with('emessage', 'Insufficient available balance');
        }
    }

    private function isCardWithdrawAvailable()
    {
        /** @var \App\User $user */
        $user = Auth::User();
        $profile = Profile::where("id", "=", Auth::User()->id)->first();
        $business = Business::where("user_id", "=", Auth::User()->id)->first();

        if ($profile->country == 'United States')
            return false;

        if (($user->account_type == 'business') && ($business->country == 'United States'))
            return false;

        return true;
    }
}

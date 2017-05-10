<?php

namespace App\Http\Controllers\User;

use App\Accounts;
use App\Business;
use App\Commands;
use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

//use \Crypt;

class AccountsController extends Controller
{

    private $_addAccountfields, $_accountNumberRules, $_fieldCountries, $_createdAccountId;

    public function __construct()
    {
        $this->_addAccountfields = $this->_accountNumberRules = $this->_fieldCountries = [];
        $this->_createdAccountId = null;
    }

    /**
     * _initAddAccountPageDynamicData
     *
     * method to initialize fields array
     * created Aug 30, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _initAddAccountPageDynamicData()
    {
        $this->_loadSepaCountryFields();
        $this->_loadNonSepaCountryFields();
        $this->_loadLocalizedCountryFields(); //loaded in the end to override any prior functions definitions
        $this->_loadOtherCountryFields();
        $this->_addAccountfields['others'] = ['account_name', 'bank_name', 'swift_code', 'branch_address', 'account_number'];

        $this->_loadAccountNumberRules();
        $this->_groupFieldCountries();
    }

    /**
     * _loadSepaCountryFields
     *
     * method to load fields for SEPA countries
     * created Aug 30, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _loadSepaCountryFields()
    {
        $countries = \App\SepaCountries::all();
        $countries->each(function ($country, $key) {
            $this->_addAccountfields[$country->country_name] = ['account_name', 'bank_name', 'account_number'];
        });
    }

    /**
     * _loadNonSepaCountryFields
     *
     * method to load fields for non-SEPA countries
     * created Aug 30, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _loadNonSepaCountryFields()
    {
        $countries = \App\NonSepaCountries::all();
        $countries->each(function ($country, $key) {
            $this->_addAccountfields[$country->country_name] = ['account_name', 'bank_name', 'swift_code', 'account_number'];
        });
    }

    /**
     * _loadLocalizedCountryFields
     *
     * method to load fields for localized countries
     * created Aug 30, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _loadLocalizedCountryFields()
    {
        $this->_addAccountfields['United Kingdom'] = ['account_name', 'bank_name', 'sort_code', 'account_number'];
        $this->_addAccountfields['United States'] = ['account_name', 'bank_name', 'account_type', 'routing_number', 'account_number'];
        $this->_addAccountfields['India'] = ['account_name', 'bank_name', 'ifsc_code', 'account_number'];
        $this->_addAccountfields['Canada'] = ['account_name', 'bank_name', 'transit_number', 'institution_number', 'account_number'];
        $this->_addAccountfields['Australia'] = ['account_name', 'bank_name', 'bsb', 'account_number'];
        $this->_addAccountfields['New Zealand'] = ['account_name', 'bank_name', 'bsb', 'account_number'];
        $this->_addAccountfields['Japan'] = ['account_name', 'bank_name', 'bank_code', 'branch_code', 'account_type', 'account_number'];
        $this->_addAccountfields['Malaysia'] = ['account_name', 'bank_name', 'meps', 'account_number'];
        $this->_addAccountfields['Mexico'] = ['account_name', 'bank_name', 'account_number'];
        $this->_addAccountfields['Philippines'] = ['account_name', 'bank_name', 'brstn_code', 'account_number'];
    }

    /**
     * _loadOtherCountryFields
     *
     * method to load fields from other countries
     * created Sep 19, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _loadOtherCountryFields()
    {
        $countries = \App\Countries::all();
        $countries->each(function ($country, $key) {
            if (!isset($this->_addAccountfields[$country->country_name]))
                $this->_addAccountfields[$country->country_name] = ['account_name', 'bank_name', 'swift_code', 'branch_address', 'account_number'];
        });
    }

    /**
     * _loadAccountNumberRules
     *
     * method to load account number rules stored in database
     * created Aug 31, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _loadAccountNumberRules()
    {
        $this->_accountNumberRules = [];
        $rules = \App\BankAccountNumberRules::all();
        $rules->each(function ($rule) {
            $this->_accountNumberRules[$rule->country] = [
                'country' => $rule->country,
                'min' => $rule->min,
                'max' => $rule->max,
                'field' => $rule->field,
                'regex_pattern' => $rule->regex_pattern,
                'placeholder' => $rule->placeholder,
                'pattern_mismatch_text' => $rule->pattern_mismatch_text,
                'sepa_member' => $rule->sepa_member
            ];
        });

        return $this->_accountNumberRules;
    }

    /**
     * _groupFieldCountries
     *
     * method to group countries by field
     * created Aug 31, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _groupFieldCountries()
    {
        $this->_fieldCountries = [];
        foreach ($this->_addAccountfields as $country => $fields) {
            foreach ($fields as $field) {
                $this->_fieldCountries[$field][] = str_replace(" ", "-", strtolower($country));
            }
        }
        return $this->_fieldCountries;
    }

    /**
     * accounts
     *
     * action method to list all added accounts
     * modified Sep 2, 2016 by Naman Attri
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function accounts()
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
        $i = 1;
        $query = Accounts::where('accounts.user_id', '=', Auth::user()->id)
            ->where('accounts.is_removed', '=', 0)
            ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
            ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.user_id', '=', 'accounts.user_id')
            ->select('accounts.*', 'account_verification_details.account_user_id', 'user_identity_verification_details.ssn')
            ->orderBy('accounts.is_primary', 'DESC')
            ->orderBy('accounts.id', 'ASC');
        $totalAccounts = $query->count();
        $accounts = $query->get();
        $dataSet = [];
        $accounts->each(function ($account) use (&$dataSet) {
            $dataSet[] = [
                'id' => $account->id,
                'bank_name' => $account->bank_name,
                'account_number' => $this->_getFormattedAccountNumber($account),
                'is_primary' => $account->is_primary,
                'status' => $this->_getStatus($account)
            ];
        });

        return view('User.dashboard.accounts.accounts', compact('dataSet', 'i', 'totalAccounts'));
    }

    /**
     * _getStatus
     *
     * method to get Status of bank accounts
     * created Sep 9, 2016
     * modified Sep 12, 2016 As asked by client for Non-US accounts show "Added" by default
     *  Primary and Make Primary links to be completely removed
     *
     * @param $account
     * @return String
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _getStatus($account)
    {
        switch ($account->country) {
            case 'United States':
                if (!$account->account_user_id || !$account->ssn)
                    return "Not added<br /><a href=\"" . route('verify_account_identity', ['accountId' => $account->id]) . "\" data-toggle=\"modal\" data-target=\"#verifyYourBankAccountAndIdentityModal\" data-dismiss=\"modal\" data-backdrop=\"static\" data-keyboard=\"false\" id=\"dialogOpenBtn\">Complete adding account</a>";
                return 'Added';
            default:
                return 'Added';
        }
    }

    /**
     * _getFormattedAccountNumber
     *
     * method to get formatted account number
     * created Sep 2, 2016
     *
     * @param $account
     * @return string
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _getFormattedAccountNumber($account)
    {
        if (!empty($account->account_number)) {
            return $this->_formatSensitiveNumbers($account->account_number);
        } elseif (!empty($account->iban)) {
            return $this->_formatSensitiveNumbers($account->iban);
        } elseif (!empty($account->clabe)) {
            return $this->_formatSensitiveNumbers($account->clabe);
        }
    }

    /**
     * _formatSensitiveNumbers
     *
     * method to format bank account and card numbers to hide sensitive information
     * created Aug 25, 2016
     * modified Sep 16, 2016 If number is 4 characters - show the entire number with no masking
     *
     * @param $number
     * @return string
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _formatSensitiveNumbers($number)
    {
        return strlen($number) - 4 > 0 ? str_repeat("*", strlen($number) - 4) . substr($number, -4) : $number;
    }

    /**
     * addAccount
     *
     * action method for add account page
     * modified Sep 2, 2016 by Naman Attri
     *
     * @return mixed
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function addAccount()
    {
        $this->_initAddAccountPageDynamicData();
        $user = User::find(Auth::user()->id);
        $userp = Profile::where('id', '=', Auth::user()->id)->first();
        $userb = Business::where('user_id', '=', Auth::user()->id)->first();

        return view('User.dashboard.accounts.add', compact('user', 'userp', 'userb'))->with('accountNumberRules', $this->_accountNumberRules)->with('fieldCountries', $this->_fieldCountries);
    }

    public function makePrimary($id)
    {
        $update = Accounts::where('user_id', '=', Auth::user()->id)->where('is_primary', '=', 'Yes')->update(['is_primary' => 'No']);
        $update = Accounts::where('id', '=', $id)->update(['is_primary' => 'Yes']);
        return Redirect()->route('bank-accounts')->with('message', 'You have successfully changed your primary bank account ');
    }

    /**
     * createAccountSuccess
     *
     * action method to redirect to accounts grid page with success messages
     * created Sep 6, 2016
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function createAccountSuccess()
    {
        return Redirect()->route('bank-accounts')->with('message', 'You have successfully added a bank account.');
    }

    /**
     * createAccount
     *
     * action method to create a bank account record based on the supplied data
     * created Sep 1, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function createAccount(Request $request)
    {
        $this->_initAddAccountPageDynamicData();
        $postParams = $request->all();
        unset($postParams['_token']);

        $saveParams = $postParams['saveParams'];

        $createdAccountId = $this->_createAccountRecord($request, $saveParams);

        //return success response
        return response()->json(['error' => false, 'message' => 'Function completed Successfully!', 'createdAccountId' => $createdAccountId]);
    }

    /**
     * _createAccountRecord
     *
     * method to create account record in database
     * created Sep 9, 2016 extracted from create account action method
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _createAccountRecord(Request $request, $saveParams)
    {
        //validate payload
        $accountNumberValidationRules = $this->_getAccountNumberValidationRules($saveParams['country']);
        $validator = Validator::make($saveParams, [
            'account_name' => !empty($saveParams['account_name']) ? 'required' : '',
            'bank_name' => !empty($saveParams['bank_name']) ? 'required' : '',
            'account_number' => !empty($saveParams['account_number']) ? $accountNumberValidationRules : '',
            'iban' => !empty($saveParams['iban']) ? $accountNumberValidationRules : '',
            'account_type' => !empty($saveParams['account_type']) ? 'required' : '',
            'swift_code' => !empty($saveParams['swift_code']) ? 'required|alpha_num|regex:/^[a-zA-Z0-9]{8}([a-zA-Z0-9]{3})?$/' : '',
            'branch_address' => !empty($saveParams['branch_address']) ? 'required' : '',
            'sort_code' => !empty($saveParams['sort_code']) ? 'required|numeric|digits:6' : '',
            'routing_number' => !empty($saveParams['routing_number']) ? 'required|numeric|digits:9' : '',
            'ifsc_code' => !empty($saveParams['ifsc_code']) ? 'required|alpha_num|min:11|max:11' : '',
            'transit_number' => !empty($saveParams['transit_number']) ? 'required|numeric|digits:5' : '',
            'institution_number' => !empty($saveParams['institution_number']) ? 'required|numeric|digits:3' : '',
            'bsb' => !empty($saveParams['bsb']) ? 'required|numeric|digits:6' : '',
            'bank_code' => !empty($saveParams['bank_code']) ? 'required|numeric|digits:4' : '',
            'branch_code' => !empty($saveParams['branch_code']) ? 'required|numeric|digits:3' : '',
            'meps' => !empty($saveParams['meps']) ? 'required|alpha_num|min:8|max:8' : '',
            'clabe' => !empty($saveParams['clabe']) ? $accountNumberValidationRules : '',
            'brstn_code' => !empty($saveParams['brstn_code']) ? 'required|numeric|digits:9' : '',
        ]);

        if ($validator->fails())
            return response()->json(['error' => true, 'message' => 'Security Threat - Tampered Request Payload!']);
        if ($this->_foundDuplicacy($saveParams))
            return response()->json([
                'error' => true,
                'message' => 'An error ocurred. This bank account can\'t be added right now'
            ]);
        //return failure response if occurs
        //create account record
        $accountRecord = new \App\Accounts();
        $accountRecord->user_id = Auth::user()->id;
        array_walk($saveParams, function ($value, $field) use ($accountRecord) {
            $accountRecord->{$field} = $value;
        });
        $accountRecord->save();
        return $accountRecord->id;
    }

    /**
     * _getAccountNumberValidationRules
     *
     * method to get rules for account number country specific
     * created Sep 1, 2016
     *
     * @param $country
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _getAccountNumberValidationRules($country)
    {
        $rule = "required";
        if (isset($this->_accountNumberRules[$country])) {
            $accountNumberRules = $this->_accountNumberRules[$country];
            if (!empty($accountNumberRules['min']) && !empty($accountNumberRules['max'])) {
                $rule .= "|min:{$accountNumberRules['min']}|max:{$accountNumberRules['max']}";
            } elseif (!empty($accountNumberRules['min']) && empty($accountNumberRules['max'])) {
                $rule .= "|min:{$accountNumberRules['min']}";
            } elseif (empty($accountNumberRules['min']) && !empty($accountNumberRules['max'])) {
                $rule .= "|max:{$accountNumberRules['max']}";
            }

            if (!empty($accountNumberRules['regex_pattern'])) {
                $rule .= "|regex:/{$accountNumberRules['regex_pattern']}/";
            }
        }
        return $rule;
    }

    /**
     * _foundDuplicacy
     *
     * method to check if supplied data has duplicacy
     * created Sep 1, 2016
     *
     * @param $postParams
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _foundDuplicacy(&$postParams)
    {
        //Malaysia
        switch ($postParams['country']) {
            case 'United States':
                return boolval(\App\Accounts::where('routing_number', $postParams['routing_number'])->where('account_number', $postParams['account_number'])->count());
            case 'India':
                return boolval(\App\Accounts::where('ifsc_code', $postParams['ifsc_code'])->where('account_number', $postParams['account_number'])->count());
            case 'Canada':
                return boolval(\App\Accounts::where('transit_number', $postParams['transit_number'])->where('institution_number', $postParams['institution_number'])->where('account_number', $postParams['account_number'])->count());
            case 'Australia':
            case 'New Zealand':
                return boolval(\App\Accounts::where('bsb', $postParams['bsb'])->where('account_number', $postParams['account_number'])->count());
            case 'Japan':
                return boolval(\App\Accounts::where('bank_code', $postParams['bank_code'])->where('branch_code', $postParams['branch_code'])->where('account_number', $postParams['account_number'])->count());
            case 'Malaysia':
                return boolval(\App\Accounts::where('meps', $postParams['meps'])->where('account_number', $postParams['account_number'])->count());
            case 'Mexico':
                return boolval(\App\Accounts::where('clabe', $postParams['clabe'])->count());
            case 'Philippines':
                return boolval(\App\Accounts::where('brstn_code', $postParams['brstn_code'])->where('account_number', $postParams['account_number'])->count());
            case 'United Kingdom':
                return boolval(\App\Accounts::where('sort_code', $postParams['sort_code'])->where('account_number', $postParams['account_number'])->count());
        }

        if (!empty($postParams['iban']))
            return boolval(\App\Accounts::where('iban', $postParams['iban'])->count());

        if (!empty($postParams['swift_code'])) {
            switch (strlen($postParams['swift_code'])) {
                case 8: //8 digit swift code
                    $foundRecord = \App\Accounts::where('swift_code', $postParams['swift_code'])->where('account_number', $postParams['account_number'])->first();
                    if (!$foundRecord)
                        return false;
                    $percent = 0;
                    similar_text($foundRecord->account_name, $postParams['account_name'], $percent);
                    return $percent > 70; //if there is a 70% match in the account name : then it's a duplicate
                case 11: //10 digit swift code
                    return boolval(\App\Accounts::where('swift_code', $postParams['swift_code'])->where('account_number', $postParams['account_number'])->count());
            }
        }
    }

    /**
     * duplicateAttempt
     *
     * action method to check if current account creation is a duplicate attempt
     * created Sep 9, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function duplicateAttempt(Request $request)
    {
        $postParams = $request->all();
        unset($postParams['_token']);
        $this->_initAddAccountPageDynamicData();

        $saveParams = $postParams['saveParams'];
        $accountNumberValidationRules = $this->_getAccountNumberValidationRules($saveParams['country']);
        $validator = Validator::make($saveParams, [
            'account_name' => !empty($saveParams['account_name']) ? 'required' : '',
            'bank_name' => !empty($saveParams['bank_name']) ? 'required' : '',
            'account_number' => !empty($saveParams['account_number']) ? $accountNumberValidationRules : '',
            'iban' => !empty($saveParams['iban']) ? $accountNumberValidationRules : '',
            'account_type' => !empty($saveParams['account_type']) ? 'required' : '',
            'swift_code' => !empty($saveParams['swift_code']) ? 'required|alpha_num|regex:/^[a-zA-Z0-9]{8}([a-zA-Z0-9]{3})?$/' : '',
            'branch_address' => !empty($saveParams['branch_address']) ? 'required' : '',
            'sort_code' => !empty($saveParams['sort_code']) ? 'required|numeric|digits:6' : '',
            'routing_number' => !empty($saveParams['routing_number']) ? 'required|numeric|digits:9' : '',
            'ifsc_code' => !empty($saveParams['ifsc_code']) ? 'required|alpha_num|min:11|max:11' : '',
            'transit_number' => !empty($saveParams['transit_number']) ? 'required|numeric|digits:5' : '',
            'institution_number' => !empty($saveParams['institution_number']) ? 'required|numeric|digits:3' : '',
            'bsb' => !empty($saveParams['bsb']) ? 'required|numeric|digits:6' : '',
            'bank_code' => !empty($saveParams['bank_code']) ? 'required|numeric|digits:4' : '',
            'branch_code' => !empty($saveParams['branch_code']) ? 'required|numeric|digits:3' : '',
            'meps' => !empty($saveParams['meps']) ? 'required|alpha_num|min:8|max:8' : '',
            'clabe' => !empty($saveParams['clabe']) ? $accountNumberValidationRules : '',
            'brstn_code' => !empty($saveParams['brstn_code']) ? 'required|numeric|digits:9' : '',
        ]);
        if ($validator->fails())
            return response()->json(['error' => true, 'message' => 'Security Threat - Tampered Request Payload!']);
        if ($this->_foundDuplicacy($saveParams))
            return response()->json([
                'error' => true,
                'message' => 'An error ocurred. This bank account can\'t be added right now.'
            ]);
        return response()->json(['error' => false, 'message' => 'New Account.']);
    }

    /**
     * remove
     *
     * action method to remove a bank account
     * modified Sep 2, 2016 by Naman Attri
     *
     * @param $id
     * @return mixed
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function remove($id)
    {
        //\App\Accounts::find($id)->delete();

        $query = Accounts::where('accounts.user_id', '=', Auth::user()->id)
            ->where('accounts.is_removed', '=', 0)
            ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
            ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.user_id', '=', 'accounts.user_id')
            ->select('accounts.*', 'account_verification_details.account_user_id', 'user_identity_verification_details.ssn')
            ->orderBy('accounts.is_primary', 'DESC')
            ->orderBy('accounts.id', 'ASC')
            ->offset($id - 1)->limit($id);

        $account = $query->get()->first();

        if (!$account)
            return Redirect()->route('bank-accounts')->with("message", 'Account not found');

        $account->is_removed = true;
        $account->save();

        return Redirect()->route('bank-accounts')->with("message", 'Account removed Successfully.');
    }

    public function removeArchived($id)
    {
        //\App\Accounts::find($id)->delete();
        $command = Commands::where('commands.name', '=', Commands::COMMAND_ARCHIVED_ACCOUNTS_PAGE)->first();

        $query = Accounts::where('accounts.user_id', '=', Auth::user()->id)
            ->where('accounts.is_removed', '=', 1)
            ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
            ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.user_id', '=', 'accounts.user_id')
            ->select('accounts.*', 'account_verification_details.account_user_id', 'user_identity_verification_details.ssn')
            ->orderBy('accounts.is_primary', 'DESC')
            ->orderBy('accounts.id', 'ASC')
            ->offset($id - 1)->limit($id);

        $account = $query->get()->first();

        if (!$account)
            return Redirect()->route('bank-accounts-archived', ['command' => $command->value])->with("message", 'Account not found');

        $account->delete();

        return Redirect()->route('bank-accounts-archived', ['command' => $command->value])->with("message", 'Account removed Successfully.');
    }

    /**
     * identityInfoSubmitted
     *
     * method to check if the user has submitted identity information
     * created Sep 9, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function identityInfoSubmitted(Request $request)
    {
        return response()->json(['found' => boolval(\App\UserIdentityVerificationDetails::where('user_id', Auth::user()->id)->count())]);
    }

    /**
     * verifyAccountAndIdentity
     *
     * action method to verify bank account & identity
     * created Sep 9, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function verifyAccountAndIdentity(Request $request, $accountId = null)
    {
        return view('User.dashboard.accounts.verify')->with("accountId", $accountId)->with("accountVerified", boolval(\App\AccountVerificationDetails::where('account_id', $accountId)->count()));
    }

    /**
     * saveVerificationDetails
     *
     * action method to save verification details
     * created Sep 9, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function saveVerificationDetails(Request $request, $accountId)
    {
        $postParams = $request->all();

        //save account verification details
        if (isset($postParams['verifyAccount'])) {
            $accountVerificationDetails = new \App\AccountVerificationDetails();
            $accountVerificationDetails->account_id = $accountId;
            $accountVerificationDetails->account_user_id = $postParams['verifyAccount']['bankAccountUserIdTxt'];
            $accountVerificationDetails->account_password = $postParams['verifyAccount']['bankAccountPasswordPwd'];
            $accountVerificationDetails->save();
        }
        //save identity verification details
        if (isset($postParams['verifyIdentity'])) {
            $userIdentityVerificationDetails = new \App\UserIdentityVerificationDetails();
            $userIdentityVerificationDetails->account_id = $accountId;
            $userIdentityVerificationDetails->user_id = Auth::user()->id;
            $userIdentityVerificationDetails->ssn = $postParams['verifyIdentity']['ssnTxt'];
            $userIdentityVerificationDetails->drivers_license_number = $postParams['verifyIdentity']['driversLicenseNumberTxt'];
            $userIdentityVerificationDetails->save();

            //to show first bank account on top of the list
            $update = Accounts::where('user_id', '=', Auth::user()->id)->where('is_primary', '=', 'Yes')->update(['is_primary' => 'No']);
            $update = Accounts::where('id', '=', $accountId)->update(['is_primary' => 'Yes']);
        }

        return response()->json([
            'error' => false,
            'message' => 'Function completed successfully!'
        ]);
    }

    /**
     * authorization
     *
     * action method to load authorization page
     * created Sep 8, 2016
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function authorization($id)
    {
        $viewAccountId = $id;
        return view('User.dashboard.accounts.authorization', compact('viewAccountId'));
    }

    /**
     * view
     *
     * action method to view account details
     * created Sep 9, 2016
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function view(Request $request)
    {
        $this->_initAddAccountPageDynamicData();
        $account = Accounts::where('accounts.user_id', '=', Auth::user()->id)
            ->where('accounts.id', '=', $request->input('viewAccountIdHid'))
            ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
            ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.account_id', '=', 'accounts.id')
            ->first();

        if (!$account)
            abort(403);

        return view('User.dashboard.accounts.details', compact('account'))->with('accountFields', $this->_addAccountfields);
    }

    public function predefinedEncryptCommands(Request $request, $command, $id = null)
    {
        $encrypt_method = Config::get('constants.ENCRYPT_METHOD');
        //pls set your unique hashing key
        $secret_key = Config::get('constants.SECRET_KEY');
        $secret_iv = Config::get('constants.SECRET_IV');

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        // $command = openssl_decrypt(base64_decode($command), $encrypt_method, $key, 0, $iv);
        $url = explode("/", $command);
        // $command = $url[0];
        // $id = $url[1];
        $command = Commands::where('commands.value', '=', $command)->first();

        if (!$command)
            // echo "string";

            abort(403);

        switch ($command->name) {
            case Commands::COMMAND_ACCOUNT_PAGE:
                if (!$id)
                    abort(404);

                $account = Accounts::where('accounts.user_id', '=', Auth::user()->id)
                    ->where('accounts.is_removed', '=', 0)
                    ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
                    ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.account_id', '=', 'accounts.id')
                    ->orderBy('accounts.is_primary', 'DESC')
                    ->orderBy('accounts.id', 'ASC')
                    ->offset($id - 1)->limit($id)
                    ->first();

                if (!$account)
                    abort(404);

                return $this->accountPageCommand($request, $id, $account);
                break;
            case Commands::COMMAND_ARCHIVED_ACCOUNT_PAGE:
                if (!$id)
                    abort(404);

                $account = Accounts::where('accounts.user_id', '=', Auth::user()->id)
                    ->where('accounts.is_removed', '=', 1)
                    ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
                    ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.account_id', '=', 'accounts.id')
                    ->orderBy('accounts.is_primary', 'DESC')
                    ->orderBy('accounts.id', 'ASC')
                    ->offset($id - 1)->limit($id)
                    ->first();

                if (!$account)
                    abort(404);

                return $this->archivedAccountPageCommand($request, $id, $account);
                break;
            case Commands::COMMAND_ARCHIVED_ACCOUNTS_PAGE:
                return $this->archivedAccountsPageCommand();
                break;
        }

        return abort(400);
    }

    // developer 2 code start : 22.02.2017

    public function predefinedEncryptCommandsDetails(Request $request, $command, $id = null)
    {
        $encrypt_method = Config::get('constants.ENCRYPT_METHOD');
        //pls set your unique hashing key
        $secret_key = Config::get('constants.SECRET_KEY');
        $secret_iv = Config::get('constants.SECRET_IV');

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $command = openssl_decrypt(base64_decode($command), $encrypt_method, $key, 0, $iv);
        $url = explode("/", $command);
        $command = $url[0];
        $id = $url[1];
        $command = Commands::where('commands.value', '=', $command)->first();

        if (!$command)
            // echo "string";
            abort(403);

        switch ($command->name) {
            case Commands::COMMAND_ACCOUNT_PAGE:
                if (!$id)
                    abort(404);

                $account = Accounts::where('accounts.user_id', '=', Auth::user()->id)
                    ->where('accounts.is_removed', '=', 0)
                    ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
                    ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.account_id', '=', 'accounts.id')
                    ->orderBy('accounts.is_primary', 'DESC')
                    ->orderBy('accounts.id', 'ASC')
                    ->offset($id - 1)->limit($id)
                    ->first();

                if (!$account)
                    abort(404);

                return $this->accountPageCommand($request, $id, $account);
                break;
            case Commands::COMMAND_ARCHIVED_ACCOUNT_PAGE:
                if (!$id)
                    abort(404);

                $account = Accounts::where('accounts.user_id', '=', Auth::user()->id)
                    ->where('accounts.is_removed', '=', 1)
                    ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
                    ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.account_id', '=', 'accounts.id')
                    ->orderBy('accounts.is_primary', 'DESC')
                    ->orderBy('accounts.id', 'ASC')
                    ->offset($id - 1)->limit($id)
                    ->first();

                if (!$account)
                    abort(404);

                return $this->archivedAccountPageCommand($request, $id, $account);
                break;
            case Commands::COMMAND_ARCHIVED_ACCOUNTS_PAGE:
                return $this->archivedAccountsPageCommand();
                break;
        }

        return abort(400);


    }

    // developer 2 code end : 22.02.2017


    public function predefinedCommand(Request $request, $id = null, $command)
    {
        // echo $command;
        // echo $id ; die;

        $command = Commands::where('commands.value', '=', $command)->first();

        if (!$command)
            abort(403);

        switch ($command->name) {
            case Commands::COMMAND_ACCOUNT_PAGE:
                if (!$id)
                    abort(404);

                $account = Accounts::where('accounts.user_id', '=', Auth::user()->id)
                    ->where('accounts.is_removed', '=', 0)
                    ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
                    ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.account_id', '=', 'accounts.id')
                    ->orderBy('accounts.is_primary', 'DESC')
                    ->orderBy('accounts.id', 'ASC')
                    ->offset($id - 1)->limit($id)
                    ->first();

                if (!$account)
                    abort(404);

                return $this->accountPageCommand($request, $id, $account);
                break;
            case Commands::COMMAND_ARCHIVED_ACCOUNT_PAGE:
                if (!$id)
                    abort(404);

                $account = Accounts::where('accounts.user_id', '=', Auth::user()->id)
                    ->where('accounts.is_removed', '=', 1)
                    ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
                    ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.account_id', '=', 'accounts.id')
                    ->orderBy('accounts.is_primary', 'DESC')
                    ->orderBy('accounts.id', 'ASC')
                    ->offset($id - 1)->limit($id)
                    ->first();

                if (!$account)
                    abort(404);

                return $this->archivedAccountPageCommand($request, $id, $account);
                break;
            case Commands::COMMAND_ARCHIVED_ACCOUNTS_PAGE:
                return $this->archivedAccountsPageCommand();
                break;
        }

        return abort(400);
    }

    private function archivedAccountPageCommand(Request $request, $id, Accounts $account)
    {
        /* if ($request->method() == 'POST')
          { */
        /* $user = \App\User::where('id', Auth::user()->id)->
          where('authorization_password', $request->input('authorizationPasswordPwd'))->first();
          if ($user)
          { */
        $this->_initAddAccountPageDynamicData();
        $account = Accounts::where('accounts.user_id', '=', Auth::user()->id)
            ->where('accounts.is_removed', '=', 1)
            ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
            ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.account_id', '=', 'accounts.id')
            ->orderBy('accounts.is_primary', 'DESC')
            ->orderBy('accounts.id', 'ASC')
            ->offset($id - 1)->limit($id)
            ->first();

        if (!$account)
            abort(403);

        return view('User.dashboard.accounts.details', compact('account'))->with('accountFields', $this->_addAccountfields);
        /* }
          }
          $viewAccountId = $account->id;
          return view('User.dashboard.accounts.authorization', compact('viewAccountId')); */
    }

    private function archivedAccountsPageCommand()
    {
        $i = 1;
        $query = Accounts::where('accounts.user_id', '=', Auth::user()->id)
            ->where('accounts.is_removed', '=', 1)
            ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
            ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.user_id', '=', 'accounts.user_id')
            ->select('accounts.*', 'account_verification_details.account_user_id', 'user_identity_verification_details.ssn')
            ->orderBy('accounts.is_primary', 'DESC')
            ->orderBy('accounts.id', 'ASC');
        $totalAccounts = $query->count();
        $accounts = $query->get();
        $dataSet = [];
        $accounts->each(function ($account) use (&$dataSet) {
            $dataSet[] = [
                'id' => $account->id,
                'bank_name' => $account->bank_name,
                'account_number' => $this->_getFormattedAccountNumber($account),
                'is_primary' => $account->is_primary,
                'status' => $this->_getStatus($account),
                'command' => Commands::where('commands.name', '=', Commands::COMMAND_ARCHIVED_ACCOUNT_PAGE)->first()
            ];
        });

        return view('User.dashboard.accounts.accounts-archived', compact('dataSet', 'i', 'totalAccounts'));
    }

    private function accountPageCommand(Request $request, $id, Accounts $account)
    {
        /* if ($request->method() == 'POST')
          {
          $user = \App\User::where('id', Auth::user()->id)->
          where('authorization_password', $request->input('authorizationPasswordPwd'))->first();
          if ($user)
          { */
        $this->_initAddAccountPageDynamicData();
        $account = Accounts::where('accounts.user_id', '=', Auth::user()->id)
            ->where('accounts.is_removed', '=', 0)
            ->leftJoin('account_verification_details', 'account_verification_details.account_id', '=', 'accounts.id')
            ->leftJoin('user_identity_verification_details', 'user_identity_verification_details.account_id', '=', 'accounts.id')
            ->orderBy('accounts.is_primary', 'DESC')
            ->orderBy('accounts.id', 'ASC')
            ->offset($id - 1)->limit($id)
            ->first();

        if (!$account)
            abort(403);

        return view('User.dashboard.accounts.details', compact('account'))->with('accountFields', $this->_addAccountfields);
        /*    }
          }
          $viewAccountId = $account->id;
          return view('User.dashboard.accounts.authorization', compact('viewAccountId')); */
    }

}

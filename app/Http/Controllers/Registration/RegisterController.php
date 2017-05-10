<?php

namespace App\Http\Controllers\Registration;

use App\Balance;
use App\Business;
use App\Http\Controllers\Controller;
use App\Profile;
use App\States;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

//use GeoIP as GeoIP;
class RegisterController extends Controller
{

    function get_ip_details($ip_address)
    {


        //verify the IP.  
        ip2long($ip_address) == -1 || ip2long($ip_address) === false ? trigger_error("Invalid IP", E_USER_ERROR) : "";
        $result = GeoIP::getLocation($ip_address);
        print_r($result);
        if (is_array($result) && count($result) > 0) {
            $res['countryName'] = $result['country'];
            $res['region'] = $result['state'];
            $res['city'] = $result['city'];
            return $res;
        } else {
            $result = json_decode(file_get_contents("http://api.netimpact.com/qv1.php?key=zuFXgYXY5KIS8tvn&qt=geoip&d=json&q=" . $ip_address));
            $res['countryName'] = $result[0][2];
            $res['region'] = $result[0][1];
            $res['city'] = $result[0][0];
            return $res;
        }
    }

    //
    public function register()
    {
        return view('User.signUp');
    }

    public function registerPersonal()
    {
        $type = "personal";
        $nationality = getNationalities();
        $timeZones = getTimeZones();
        $country = getCountries();
        $countryCodes = getCountryCodes();

        $days = array();
        for ($d = 1; $d < 10; $d++)
            $days[$d] = '0' . $d;
        for ($d = 10; $d < 32; $d++)
            $days[$d] = $d;

        $visitorinfo = getVisitorInformation();
        $Nationality = $visitorinfo->nationality;
        $TimeZone = $visitorinfo->timezone;
        $bCountry = $visitorinfo->countryname;
        $Country = $visitorinfo->countryname;
        $countryCode = $visitorinfo->countrycode;
        return view('User.registration', compact("type", "nationality", "country", "countryCodes", "timeZones", "Nationality", "TimeZone", "bCountry", "Country", "countryCode", 'days'));
    }

    public function registerBusiness()
    {
        $type = "business";
        $nationality = getNationalities();
        $timeZones = getTimeZones();
        $country = getCountries();
        $countryCodes = getCountryCodes();

        $days = array();
        for ($d = 1; $d < 10; $d++)
            $days[$d] = '0' . $d;
        for ($d = 10; $d < 32; $d++)
            $days[$d] = $d;

        $visitorinfo = getVisitorInformation();
        $Nationality = $visitorinfo->nationality;
        $TimeZone = $visitorinfo->timezone;
        $bCountry = $visitorinfo->countryname;
        $Country = $visitorinfo->countryname;
        $countryCode = $visitorinfo->countrycode;

        return view('User.registration', compact("type", "nationality", "country", "countryCodes", "timeZones", "Nationality", "TimeZone", "bCountry", "Country", "countryCode", 'days'));
    }

    public function doRegisterPersonal()
    {
        $rules = array(
            'Email' => 'unique:users|required|email',
            'Password' => ['required', 'regex:/^(?=.*?)(?=.*?)(?=.*?[0-9]|[#?!@$%^&*-]).{8,}$/'],
            'PasswordAgain' => ['required', 'regex:/^(?=.*?)(?=.*?)(?=.*?[0-9]|[#?!@$%^&*-]).{8,}$/', 'same:Password'],
            'countryCode' => 'required',
            'TimeZone' => 'required',
            'FirstName' => 'required',
            'LastName' => 'required',
            'Country' => 'required',
            'Address1' => 'required',
            'City' => 'required',
            'Postal' => 'required',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            'Nationality' => 'required',
            'captcha' => 'required|valid_captcha',
        );
        $len = 17 - strlen(Input::get('countryCode'));
        $rules['PhoneNo'] = 'digits_between:4,15';

        $messsages = array(
            'Email.unique' => 'This email address is already in use',
            'captcha.same.required' => 'The captcha is required',
            'PhoneNo.numeric' => 'Enter numbers only in mobile no',
            'PhoneNo.digits_between' => 'Mobile number should be between 4 to 15 characters',
            'captcha.valid_captcha' => 'Invalid captcha code',
            'PasswordAgain.same' => 'Passwords do not match'
        );

        if (Input::get('Country') == 'India') {
            $len = 6;
            $rules['Postal'] = 'required|size:' . $len;
            $messsages['Postal'] = "Pin code must be required";
            $messsages['Postal.size'] = "Pin code must be " . $len . " characters";
            $rules['State'] = 'required';
        } elseif (Input::get('Country') == 'United States') {
            $len = 5;
            $rules['Postal'] = 'required|size:' . $len;
            $messsages['Postal'] = "Zip must be required";
            $messsages['Postal.size'] = "Zip must be " . $len . " characters";
            $rules['State'] = 'required';
        } else {
            $rules['Postal'] = 'required';
        }
        $validator = Validator::make(Input::all(), $rules, $messsages);
        if ($validator->fails()) {
            return Redirect::to("/register/personal")->withErrors($validator)->withInput(Input::all());
        } else {
            $user = new User;
            $profile = new Profile;
            $phone = Input::get('countryCode') . "-" . Input::get('PhoneNo');
            $user->email = Input::get('Email');
            $user->password = Hash::make(Input::get('Password'));
            $user->confirmation_code = str_random(30);
            $user->type = "0";
            $user->account_type = "personal";
            $user->save();
            $profile->id = $user->id;
            $profile->fname = Input::get('FirstName');
            $profile->lname = Input::get('LastName');
            $profile->mname = Input::get('MiddleName');
            $profile->address_one = Input::get('Address1');
            $profile->address_two = Input::get('Address2');
            $profile->country = Input::get('Country');
            $profile->city = Input::get('City');
            $profile->state = Input::get('State');
            $profile->postal = Input::get('Postal');
            $profile->mobile = $phone;
            $profile->dob = Input::get('month') . "/" . Input::get('day') . "/" . Input::get('year');
            $profile->nationality = Input::get('Nationality');
            $profile->timezone = Input::get('TimeZone');
            $profile->save();
            $userbalance = new Balance;
            $userbalance->id = $user->id;
            $userbalance->balance = 0;
            $userbalance->save();
            $email = $user->email;
            $toName = $profile->fname . "&nbsp;" . $profile->mname . "&nbsp;" . $profile->lname;
            Mail::send('email.emailConfirmationSignUp', ["data" => $user, "profile" => $toName], function ($message) use ($user) {
                $message->from('no-reply@itcpay.com', getSiteName());
                $message->to($user->email)->subject('Email Verification for ' . getSiteName());
            });
            return Redirect('/register/user/confirmation/' . $email);
        }
    }

    public function doRegisterBusiness()
    {
        $rules = array(
            'Email' => 'unique:users|required|email',
            'Password' => ['required', 'regex:/^(?=.*?)(?=.*?)(?=.*?[0-9]|[#?!@$%^&*-]).{8,}$/'],
            'PasswordAgain' => ['required', 'regex:/^(?=.*?)(?=.*?)(?=.*?[0-9]|[#?!@$%^&*-]).{8,}$/', 'same:Password'],
            'countryCode' => 'required',
            'TimeZone' => 'required',
            'bName' => 'required',
            'bCountry' => 'required',
            'bAddress1' => 'required',
            'bCity' => 'required',
            'bPostal' => 'required',
            'FirstName' => 'required',
            'LastName' => 'required',
            'Country' => 'required',
            'Address1' => 'required',
            'City' => 'required',
            'Postal' => 'required',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            'Nationality' => 'required',
            'captcha' => 'required|valid_captcha',
        );
        $len = 17 - strlen(Input::get('countryCode'));

        $rules['PhoneNo'] = 'digits_between:4,15';
        $messsages = array(
            'Email.unique' => 'This email address is already use',
            'captcha.same.required' => 'The captcha is required',
            'PhoneNo.numeric' => 'Enter numbers only in mobile no',
            'PhoneNo.digits_between' => 'Mobile number should be between 4 to 15 characters',
            'captcha.valid_captcha' => 'Invalid captcha code',
            'PasswordAgain.same' => 'Passwords do not match',
            'bCountry.required' => 'Business country must be required',
            'bCity.required' => 'Business city must be required',
            'bName.required' => 'Business name must be required',
            'bAddress1.required' => 'Business address 1 must be required',
        );

        if (Input::get('bCountry') == 'India') {
            $len = 6;
            $rules['bPostal'] = 'required|size:' . $len;
            $messsages['bPostal.required'] = "Pin code must be required";
            $messsages['bPostal.size'] = "Pin code must be " . $len . " characters";
            $rules['bState'] = 'required';
            $messsages['bState.required'] = 'Business state must be required';
        } elseif (Input::get('bCountry') == 'United States') {
            $len = 5;
            $rules['bPostal'] = 'required|size:' . $len;
            $messsages['bPostal.required'] = "Zip must be required";
            $messsages['bPostal.size'] = "Zip must be " . $len . " characters";
            $rules['bState'] = 'required';
            $messsages['bState.required'] = 'Business state must be required';
        } else {
            $rules['bPostal'] = 'required';
            $messsages['bPostal.required'] = 'The business postal code field is required';
        }

        if (Input::get('Country') == 'India') {
            $len = 6;
            $rules['Postal'] = 'required|size:' . $len;
            $messsages['Postal.required'] = "Pin code must be required";
            $messsages['Postal.size'] = "Pin code must be " . $len . " characters";
            $rules['State'] = 'required';
            $messsages['State.required'] = "State must be required";
        } elseif (Input::get('Country') == 'United States') {
            $len = 5;
            $rules['Postal'] = 'required|size:' . $len;
            $messsages['Postal.required'] = "Zip must be required";
            $messsages['Postal.size'] = "Zip must be " . $len . " characters";
            $rules['State'] = 'required';
            $messsages['State.required'] = "State must be required";
        } else {
            $rules['Postal'] = 'required';
            $messsages['Postal.required'] = "Postal must be required";
        }

        $validator = Validator::make(Input::all(), $rules, $messsages);
        if ($validator->fails()) {
            return Redirect::to("/register/business")->withErrors($validator)->withInput(Input::all());
        } else {
            $user = new User;
            $profile = new Profile;
            $business = new Business;
            $phone = Input::get('countryCode') . Input::get('PhoneNo');
            $user->email = Input::get('Email');
            $user->password = Hash::make(Input::get('Password'));
            $user->confirmation_code = str_random(30);
            $user->type = "0";
            $user->account_type = "business";
            $user->save();
            $profile->id = $user->id;
            $profile->fname = Input::get('FirstName');
            $profile->lname = Input::get('LastName');
            $profile->mname = Input::get('MiddleName');
            $profile->address_one = Input::get('Address1');
            $profile->address_two = Input::get('Address2');
            $profile->country = Input::get('Country');
            $profile->city = Input::get('City');
            $profile->state = Input::get('State');
            $profile->postal = Input::get('Postal');
            $profile->mobile = $phone;
            $profile->dob = Input::get('month') . "/" . Input::get('day') . "/" . Input::get('year');
            $profile->nationality = Input::get('Nationality');
            $profile->timezone = Input::get('TimeZone');
            $profile->save();
            $business->user_id = $user->id;
            $business->name = Input::get('bName');
            $business->country = Input::get('bCountry');
            $business->address_one = Input::get('bAddress1');
            $business->address_two = Input::get('bAddress2');
            $business->city = Input::get('bCity');
            $business->state = Input::get('bState');
            $business->postal = Input::get('bPostal');
            $business->save();


            $userbalance = new Balance;
            $userbalance->id = $user->id;
            $userbalance->balance = 0;
            $userbalance->save();
            $email = $user->email;
            $toName = $business->name;
            Mail::send('email.emailConfirmationSignUp', ["data" => $user, "profile" => $toName], function ($message) use ($user) {
                $message->from('no-reply@itcpay.com', getSiteName());
                $message->to($user->email)->subject('Email Verification for ' . getSiteName());
            });
            return Redirect('/register/user/confirmation/' . $email);
        }
    }

    /*
     * to load confirmation pge
     *
     * @author <n.k.>
     */

    public function user_confirmation($email)
    {
        $user = User::where('email', '=', $email)->first();
        $accountType = $user->account_type;
        if ($accountType == 'business') {
            $businessData = Business::where('user_id', '=', $user->id)->first();
            $userName = $businessData->name;
        } else {
            $personalData = Profile::find($user->id);
            $userName = $personalData->fname . "&nbsp;" . $personalData->mname . "&nbsp;" . $personalData->lname;
        }
        return view('User.confirmation.confirmation', compact("email", "userName"));
    }

    public function confirmation($confirmation)
    {
        $user = User::where('confirmation_code', '=', $confirmation)->first();
        if ($user->active == 1) {
            if ($user->tmp_email != "") {
                $user->email = $user->tmp_email;
                $user->tmp_email = "";
                $user->save();
            }
            if (isset(Auth::user()->id)) {
                $message = "Your " . getSiteName() . " account's email address has been successfully changed to $user->email";
                //echo $message;die;
                return Redirect('/home')->with('message', $message);
            } else {
                $loginMessage = "Your " . getSiteName() . " account's email address has been successfully changed to $user->email";
                return view("login/login", compact('loginMessage'));
            }
        } else {
            if ($user->tmp_email != "") {
                $user->active = "1";
                $user->email = $user->tmp_email;
                $user->tmp_email = "";
                $user->save();
            }
            if (Auth::check()) {
                $message = "Your " . getSiteName() . " account's email address has been successfully changed to $user->email";
                return Redirect('/home')->with('message', $message);
            } else {
                $loginMessage = "Your " . getSiteName() . " account's email address has been successfully changed to $user->email";
                return view("login/login", compact('loginMessage'));
            }
        }
    }

    public function confirmationSignUp($confirmation)
    {
        $user = User::where('confirmation_code', '=', $confirmation)->first();

        if ($user->active == 1) {
            if (isset(Auth::user()->id)) {
                return Redirect('/home')->with('message', 'Your email address has already been verified.');
            } else {
                $loginMessage = 'Your email address has already been verified.';
                return view("login/login", compact('loginMessage'));
            }
        } else {
            $user->active = "1";
            $user->save();
            $loginMessage = 'Your email address has been successfully verified';
            return view("login/login", compact('loginMessage'));
        }
    }

    public function resend($email)
    {
        $user = User::where('email', '=', $email)->first();
        if ($user->active == 1) {
            $message = "Email address already verified.";
            return view("User.emailVerified", compact('message'));
        } else {
            $accountType = $user->account_type;
            if ($accountType == 'business') {
                $businessData = Business::where('user_id', '=', $user->id)->first();
                $profile = $businessData->name;
            } else {
                $personalData = Profile::find($user->id);
                $name = $personalData->fname . "&nbsp;" . $personalData->mname . "&nbsp;" . $personalData->lname;
                $profile = $name;
            }
            Mail::send('email.emailConfirmationResend', ["data" => $user, "profile" => $profile], function ($message) use ($user) {
                $message->from('no-reply@itcpay.com', getSiteName());
                $message->to($user->email)->subject('Email Verification for ' . getSiteName());
            });
            return view('User.confirmation.resend', compact("email"));
        }
    }

    /*
     * resendChangeEmail function to send verification email again when user change his email
     * logic we check the tmp_email is empty
     *  @author navalkishor@it7solutions.com
     *
     */

    public function resendChangeEmail($email)
    {
        $user = User::where('tmp_email', '=', $email)->first();
        if (!$user) {
            $message = "Email address already verified.";
            return view("User.emailVerified", compact('message'));
        } else {
            $accountType = $user->account_type;
            if ($accountType == 'business') {
                $businessData = Business::where('user_id', '=', $user->id)->first();
                $userName = $businessData->name;
            } else {
                $personalData = Profile::find($user->id);
                $userName = $personalData->fname . "&nbsp;" . $personalData->mname . "&nbsp;" . $personalData->lname;
            }
            Mail::send('email.updateEmailConfirmation', ["data" => $user, "userName" => $userName], function ($message) use ($user) {
                $message->from('no-reply@itcpay.com', getSiteName());
                $message->to($user->email)->subject('Email Verification for ' . getSiteName());
            });
            $displayMessage = "An email with a verification link has been sent again to $email";
            return view('User.confirmation.updateemailconfirmation', compact("email", "userName", "displayMessage"));
        }
    }

    public function updateEmail()
    {
        $user = User::where('email', '=', Input::get('oldemail'))->first();
        if (!$user) {
            return view("User.confirmation.userExists");
        } else {
            $email = Input::get('Email');
            User::where('email', '=', Input::get('oldemail'))->first()->update(['tmp_email' => $email]);
            $userNew = User::where('tmp_email', '=', $email)->first();
            $accountType = $userNew->account_type;
            if ($accountType == 'business') {
                $businessData = Business::where('user_id', '=', $userNew->id)->first();
                $userName = $businessData->name;
            } else {
                $personalData = Profile::find($userNew->id);
                $userName = $personalData->fname . "&nbsp;" . $personalData->mname . "&nbsp;" . $personalData->lname;
            }
            Mail::send('email.updateEmailConfirmation', ["data" => $userNew, "userName" => $userName], function ($message) use ($userNew) {
                $message->from('no-reply@itcpay.com', getSiteName());
                $message->to($userNew->tmp_email)->subject('Email Verification for ' . getSiteName());
            });
            $displayMessage = "An email with a verification link has been sent  to $email";
            return view('User.confirmation.updateemailconfirmation', compact("email", "userName", "displayMessage"));
        }
    }

    public function changeEmail($email)
    {
        $userData = User::where('email', '=', $email)->first();
        if ($userData->active == 1) {
            return view('User.confirmation.changeEmail', compact("email"));
        } else {
            return view('User.confirmation.changeEmail', compact("email"));
        }
    }

    public function test()
    {
        return view('User.confirmation');
    }

    public function getStateList($countryName = '', $type = "personal")
    {

        $result = \App\CountryStates::select('country_states.state')
            ->where('country_states.country', '=', '' . $countryName . '')->orderBy('country_states.country')->get();
        $stateResult = $result->toArray();
        if ($type == "personal")
            $ids = "State";
        else
            $ids = "bState";

        if (!empty($stateResult)) {
            $html = "<select style='padding: 0px;' name='" . $ids . "' id='" . $ids . "' class='form-control'><option value=''>Select State</option>";

            foreach ($stateResult as $key => $value) {
                if (isset($value['state'])) {
                    $html .= '<option data-State="' . $value['state'] . '" value="' . $value['state'] . '">' . $value["state"] . '</option>';
                }
            }
            $html .= "</select>";
            $selectBox = true;
        } else {
            $html = '<input type="text" value="" name="' . $ids . '" id="' . $ids . '" placeholder = "State/province (if applicable)" class="form-control" data-parsley-group="block-0">';
            $selectBox = false;
        }
        echo json_encode(array('result' => $html, 'isSelect' => $selectBox));
        die;
        exit;
    }

}

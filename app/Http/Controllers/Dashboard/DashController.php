<?php

namespace App\Http\Controllers\Dashboard;

use App\Balance;
use App\Business;
use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use App\Verificationdoc;
use App\VerificationInformation;
use App\VerificationInformationDocuments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DashController extends Controller
{


    public function dashboard()
    {
        if (!Auth::User()->active == "1" && Auth::User()->tmp_email == "") {
            $email = Auth::User()->email;
            $profile = Profile::where("id", "=", Auth::User()->id)->first();
            //Auth::logout();
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
        $email = Auth::User()->email;
        $password = Auth::User()->password;
        $profile = Profile::where("id", "=", Auth::User()->id)->first();
        $mobile = $profile->mobile;
        $timezone = $profile->timezone;
        $acc = Auth::User()->account_type;
        $balance = Balance::find(auth()->user()->id);
        return view('User.dashboard.home', compact("acc", "email", "password", "mobile", "timezone", "balance"));
    }

    public function changeEmail()
    {
        $email = auth()->user()->email;
        return view('User.dashboard.change.changeEmail', compact("email"));
    }

    public function updateEmail()
    {
        if (Input::get('oldemail') == Input::get('Email')) {
            return Redirect::to("/dashboard")->with("message", "No change made to email address.");
        } else {
            /**
             *   Logical changes :
             *   Add new email in tmp_email
             *   send email to tmp_email for confirmation
             *   Upon Cnfimration update main email with tmp_email & empty tmp_email.
             *   Use combination of confirmation_code!="" and tmp_email == ""  as a verification and allow user to access the system.
             */
            $user1 = User::where('email', '=', Input::get('oldemail'))->first();
            if (!$user1) {
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
                return view('User.dashboard.change.updateemailconfirmation', compact("email", "userName", "displayMessage"));
            }
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
            return view('User.dashboard.change.updateemailconfirmation', compact("email", "userName", "displayMessage"));
        }
    }

    public function resend($email)
    {

        $user = User::where('email', '=', $email)->where('confirmation_code', '!=', '')->first();
        if (!$user) {
            return view("User.confirmation.userExists");
        } else {
            $profile = Profile::find($user->id);

            Mail::send('email.emailConfirmation', ["data" => $user, "profile" => $profile], function ($message) use ($user) {
                $message->from('no-reply@itcpay.com', getSiteName());
                $message->to($user->email)->subject('WELCOME!');
            });
            return view('User.confirmation.resend', compact("email"));
        }
    }

    public function changePassword()
    {
        return view('User.dashboard.change.changePassword');
    }

    public function updatePassword()
    {
        $user = User::where('email', '=', Auth::user()->email)->first();
        if (!$user) {
            return Redirect::to('dashboard/changePassword')->with("emessage", "User does not exsist");
        } else {

            $currPassword = Input::get('curr_password');
            $currDbPassword = $user->password;
            if (Hash::check($currPassword, $currDbPassword)) {
                $rules = array
                (
                    'password' => ['required', 'regex:/^(?=.*?)(?=.*?)(?=.*?[0-9]|[#?!@$%^&*-]).{8,}$/'],
                    'passwordAgain' => ['required', 'regex:/^(?=.*?)(?=.*?)(?=.*?[0-9]|[#?!@$%^&*-]).{8,}$/', 'same:password'],
                );
                $validator = Validator::make(Input::all(), $rules);
                if ($validator->fails()) {
                    return Redirect::to("dashboard/changePassword")->withErrors($validator)->withInput(Input::except('Password'));
                } else {
                    $user->password = Hash::make(Input::get('password'));
                    $user->save();
                    return Redirect::to("/my-account")->with("message", "Password changed succesfully");
                }
            } else {
                return Redirect::to('dashboard/changePassword')->with("emessage", "Current Password did not match.");
            }
        }
    }

    public function changePhone()
    {
        $countryCodes = getCountryCodes();
        $profile = Profile::where('id', '=', Auth::user()->id)->first();
        return view('User.dashboard.change.changePhone', compact("countryCodes", "profile"));
    }

    public function updatePhone()
    {
        $len = 17 - strlen(Input::get('countryCode'));
        $rules['PhoneNo'] = 'min:5|max:' . $len;
        $messages = array(
            'PhoneNo.min' => 'Invalid Mobile Number',
            'PhoneNo.max' => 'Invalid Mobile Number'
        );

        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return Redirect::to("/dashboard/changePhone")->withErrors($validator);
        } else {
            $profile = Profile::where('id', '=', Auth::user()->id)->first();
            if (!$profile) {
                "erro";
            } else {
                $phone = Input::get('countryCode') . "-" . Input::get('PhoneNo');
                $profile->mobile = $phone;
                $profile->save();
                return Redirect::to("/dashboard")->with("message", "Mobile/phone number changed successfully.");
            }
        }
    }

    public function changeTimeZone()
    {
        $timeZones = getTimeZones();
        $profile = Profile::where('id', '=', Auth::user()->id)->first();
        return view('User.dashboard.change.changeTimeZone', compact("timeZones", "profile"));
    }

    public function updateTimeZone()
    {
        $profile = Profile::where('id', '=', Auth::user()->id)->first();
        if (!$profile) {
            "erro";
        } else {
            $profile->timezone = Input::get('TimeZone');
            $profile->save();
            return Redirect::to("/dashboard")->with("message", "Time zone changed succesfully");
        }
    }

    public function personal()
    {
        $profile = Profile::where("id", "=", Auth::User()->id)->first();
        $user = User::where("id", "=", Auth::User()->id)->first();
        $fname = $profile->fname;
        $mname = $profile->mname;
        $lname = $profile->lname;
        $addressone = $profile->address_one;
        $addresstwo = $profile->address_two;
        $country = $profile->country;
        $city = $profile->city;
        $state = $profile->state;
        $postal = $profile->postal;
        $dob = $profile->dob;
        $nationality = $profile->nationality;
        $ssn = $profile->ssn;
        $name = $fname . " " . $mname . " " . $lname;
        return view('User.dashboard.personalInformation', compact('name', 'addressone', 'addresstwo', 'country', 'city', 'state', 'postal', 'dob', 'nationality', 'ssn'));
    }

    public function changeAddress()
    {
        $profile = Profile::where("id", "=", Auth::User()->id)->first();
        $country = $profile->country;
        return view('User.dashboard.change.changeAddress', compact('country'));
    }

    public function updateAddress()
    {

//        $profile = Profile::where("id", "=", Auth::User()->id)->first();
//        $profile->address_one=Input::get('Address1');
//        $profile->address_two=Input::get('Address2');
//        $profile->city=Input::get('City');
//        $profile->state=Input::get('State');
//        $profile->postal=Input::get('Postal');
//        $profile->save();


        return view('User.dashboard.change.addressChanged');
    }

    public function upgrade()
    {
        //$valid_login = Auth::user();
        //print_r($valid_login);die;
        //$profile = User::where("id", "=", Auth::User()->id)->first();
        $var = "business";
        $countries = getCountries();
        return view('User.dashboard.upgrade', compact('var', 'countries'));
    }

    public function upgradeAcc()
    {

        $var = "account";
        $countries = getCountries();
        return view('User.dashboard.upgrade', compact('var', 'countries'));
    }

    public function upgradeAccount()
    {
        $rules = array(
            'bName' => 'required',
            'bCountry' => 'required',
            'bAddress1' => 'required',
            'bCity' => 'required',
            'bState' => 'required',
        );
        $message = array(
            'bName.required' => "Business name required.",
            'bCountry.required' => "Business country required.",
            'bAddress1.required' => "Business address required.",
            'bCity.required' => "Business city required.",
            'bState.required' => "Business state required.",
            'bPostal.required' => "Postal code  required."
        );
        if (Input::get('bCountry') == 'India') {
            $len = 6;
            $rules['bPostal'] = 'required|size:' . $len;
            $message['bPostal'] = "Pin code must be required";
            $message['bPostal.size'] = "Pin code must be " . $len . " characters";
        } elseif (Input::get('bCountry') == 'United States') {
            $len = 5;
            $rules['bPostal'] = 'required|size:' . $len;
            $message['bPostal'] = "Zip must be required";
            $message['bPostal.size'] = "Zip must be " . $len . " characters";
        } else {
            $rules['bPostal'] = 'required';
        }
        $validator = Validator::make(Input::all(), $rules, $message);
        if ($validator->fails()) {
            return Redirect::to("/my-account")->withErrors($validator)->withInput();
        } else {
            $user = User::where("id", "=", Auth::User()->id)->first();
            if (!$user) {
                return "error";
            } else {
                if ($user->account_type != "business") {
                    $business = new Business;
                    $business->user_id = Auth::User()->id;
                    $business->name = Input::get('bName');
                    $business->country = Input::get('bCountry');
                    $business->address_one = Input::get('bAddress1');
                    $business->address_two = Input::get('bAddress2');
                    $business->city = Input::get('bCity');
                    $business->state = Input::get('bState');
                    $business->postal = Input::get('bPostal');
                    $business->save();
                    $user->account_type = "business";
                    $user->verify = "0";
                    $user->save();
                    if (Input::get('var') == 'account') {
                        return Redirect::to("my-account")->with("message", "You have successfully upgraded your account to a business account.");
                    } else {
                        return Redirect::to("my-account")->with("message", "You have successfully upgraded your account to a business account.");
                    }
                } else {
                    return "Your account cannot be upgraded";
                }
            }
        }
    }

    //Developer 2 code starts
    public function downgradeAccount()
    {
        $business = Business::where("user_id", "=", Auth::User()->id)->first();
        // print_r(json_decode($business));
        if ($business != "") {
            $business->delete();
        }
        $businessInformation = VerificationInformation::where("user_id", "=", Auth::User()->id)->where("type", "business")->first();
        if ($businessInformation != "") {
            $businessInformation->delete();
        }

        $user = User::where("id", "=", Auth::User()->id)->first();
        $user->account_type = "personal";
        $user->save();

        return Redirect::to("my-account")->with("message", "You have successfully downgraded your account to a personal account.");


    }

    //Developer 2 code end

    public function business()
    {
        $business = Business::where("user_id", "=", Auth::User()->id)->first();
        if (!$business) {
            return "error";
        } else {
            $name = $business->name;
            $addressone = $business->address_one;
            $addresstwo = $business->address_two;
            $country = $business->country;
            $city = $business->city;
            $state = $business->state;
            $postal = $business->postal;
            $msg = '';
            if (Session::has('message')) {
                $msg = "You have successfully upgraded your account to a business account.";
            }
            return view('User.dashboard.businessInformation', compact('name', 'addressone', 'addresstwo', 'country', 'city', 'state', 'postal', 'msg'));
        }
    }

    public function verify()
    {
        $type = Input::get('type');
        $verificationdoc = Verificationdoc::where("user_id", "=", Auth::User()->id)->first();
        $country = getCountries();
        $month = getMonth();
        return view('User.dashboard.verification', compact('type', 'verificationdoc', 'country', 'month'));
    }

    public function verifications(Request $request)
    {
        $accountType = Auth::user()->account_type;
        $personalInformation = VerificationInformation::where("user_id", "=", Auth::User()->id)->where("type", "personal")->first();
        $businessInformation = VerificationInformation::where("user_id", "=", Auth::User()->id)->where("type", "business")->first();
        return view('User.dashboard.verifications', compact('accountType', 'personalInformation', 'businessInformation'));
    }

    public function personalVerification(Request $request)
    {
        $input = $request->all();

        $messages = [
            'verification' => "An error occurred. please fill all required data",
        ];

        if (!empty($input['photo_id_exist'])) {
            $validator = Validator::make(Input::all(), [
                'Id_number' => 'required',
                'document_type' => 'required',
                'issuing_authority' => 'required',
                'photo_id' => 'required|mimes:pdf,png,jpeg,jpg,gif,bmp|max:10240',
                'address_proof' => 'mimes:pdf,png,jpeg,jpg|max:10240',
            ], $messages);
        } else {
            $validator = Validator::make(Input::all(), [
                'Id_number' => 'required',
                'photo_id' => 'required|mimes:pdf,png,jpeg,jpg,gif,bmp|max:10240',
                'document_type' => 'required',
                'issuing_authority' => 'required',
                'address_proof' => 'required|mimes:pdf,png,jpeg,jpg,gif,bmp|max:10240',
            ], $messages);
        }

        if ($validator->fails()) {
            return redirect('verify/personal-verification')
                ->withErrors($validator)
                ->withInput();
        } else {
            $verificationInformation = VerificationInformation::where("user_id", "=", Auth::User()->id)->where("type", "=", 'personal')->first();
            if (!$verificationInformation) {
                $verificationInformation = new VerificationInformation;
                $verificationInformationDocument = new VerificationInformationDocuments;
            } else {
                if ($verificationInformation->id) {
                    $verificationInformationDocument = VerificationInformationDocuments::where("verification_id", "=", $verificationInformation->id)->first();

                    if (!$verificationInformationDocument) {
                        $verificationInformationDocument = new VerificationInformationDocuments();
                    }
                }
            }
            $expiration_date = $input['expiration_year'] . '-' . $input['expiration_month'] . '-' . $input['expiration_day'];
            $issuing_date = $input['issue_year'] . '-' . $input['issue_month'] . '-' . $input['issue_day'];
            $verificationInformation->user_id = Auth::User()->id;
            $verificationInformation->type = auth()->user()->account_type;
            $verificationInformation->id_type = $input['idtype'];
            $verificationInformation->id_number = $input['Id_number'];
            $verificationInformation->issuing_authority = $input['issuing_authority'];
            $verificationInformation->expiration_date = $expiration_date;
            $verificationInformation->document_type = $input['document_type'];
            if ($input['document_type'] == 'utilitybill') {
                $verificationInformation->document_utility_type = $input['billtype'];
            } else {
                $verificationInformation->document_utility_type = "";
            }
            $verificationInformation->document_issue_date = $issuing_date;
            $verificationInformation->type = 'personal';
            $verificationInformation->is_saved = 1;
            $verificationInformation->is_rejected = 0;
            $verificationInformation->created_at = date("Y-m-d h:i:s");
            $verificationInformation->updated_at = date("Y-m-d h:i:s");
            $verificationInformation->save();
            $verification_id = $verificationInformation->id;

            if (Input::hasFile('photo_id') || Input::hasFile('address_proof')) {
                if (Input::hasFile('photo_id')) {
                    $files['photo_id'] = Input::file('photo_id');
                }
                if (Input::hasFile('address_proof')) {
                    $files['address_proof'] = Input::file('address_proof');
                }

                if (!empty($files)) {

                    foreach ($files as $key => $file) { //die("come");
                        $rules = array('file' => 'mimes:jpg,jpeg,png,pdf');
                        $validator = Validator::make(array('file' => $file), $rules);
                        if ($validator->passes()) {
                            $userid = Auth::user()->id;
                            $destinationPath = base_path() . '/html/uploads/documents/' . $userid;
                            if (!file_exists($destinationPath)) {
                                mkdir($destinationPath, 0777, true);
                            }

                            $extension = $file->getClientOriginalExtension();
                            $fileSize = $file->getSize();
                            $fileOName = $file->getClientOriginalName();
                            $fileName = $key . time() . "." . $extension;
                            $file->move($destinationPath, $fileName);

                            if ($key == 'photo_id') {
                                $verificationInformationDocument->photo_id_storage_name = $fileName;
                                $verificationInformationDocument->photo_id_original_name = $fileOName;
                                $verificationInformationDocument->photo_id_size = $fileSize;
                            } else {
                                $verificationInformationDocument->document_id_storage_name = $fileName;
                                $verificationInformationDocument->document_id_original_name = $fileOName;
                                $verificationInformationDocument->document_id_size = $fileSize;
                            }
                        }
                        $verificationInformationDocument->verification_id = $verification_id;
                        $verificationInformationDocument->save();
                    }
                }
            }


            return Redirect('verifications')->with('message', 'Personal verification information and documents updated successfully .');
        }
    }

    public function businessVerification(Request $request)
    {
        $messages = [
            'verification' => "An error occurred. please fill aal required data",
        ];
        $input = $request->all();
        $validator = Validator::make(Input::all(), [
            'company_type' => 'required',
            'employees' => 'required',
            'company_registration_no' => 'required',
            'registration_day' => 'required',
            'registration_month' => 'required',
            'registration_year' => 'required',
            'registration_country' => 'required',
            'text_id' => 'required',
            'business_addproof_issue_day' => 'required',
            'business_addproof_issue_month' => 'required',
            'business_addproof_issue_year' => 'required',
            'company_registration_document' => 'mimes:pdf,png,jpeg,jpg,gif,bmp|max:10240',
            'company_address_proof' => 'mimes:pdf,png,jpeg,jpg,gif,bmp|max:10240',
            'business_details' => 'mimes:pdf,png,jpeg,jpg,gif,bmp|max:10240',
            'authorization_letter' => 'mimes:pdf,png,jpeg,jpg,gif,bmp|max:10240',
        ], $messages);
        if ($validator->fails()) {
            return redirect('verify/business-verification')
                ->withErrors($validator)
                ->withInput();
        } else {
            $verificationInformation = VerificationInformation::where("user_id", "=", Auth::User()->id)->where("type", "=", 'business')->first();
            if (!$verificationInformation) {
                $verificationInformation = new VerificationInformation;
                $verificationInformationDocument = new VerificationInformationDocuments;
            } else {
                if ($verificationInformation->id) {
                    $verificationInformationDocument = VerificationInformationDocuments::where("verification_id", "=", $verificationInformation->id)->first();

                    if (!$verificationInformationDocument) {
                        $verificationInformationDocument = new VerificationInformationDocuments();
                    }
                }
            }

            $registration_date = $input['registration_year'] . '-' . $input['registration_month'] . '-' . $input['registration_day'];
            $business_addproof_issue_date = $input['business_addproof_issue_year'] . '-' . $input['business_addproof_issue_month'] . '-' . $input['business_addproof_issue_day'];
            $verificationInformation->user_id = Auth::User()->id;
            $verificationInformation->type = auth()->user()->account_type;
            $verificationInformation->company_type = $input['company_type'];
            $verificationInformation->number_of_employee = $input['employees'];
            $verificationInformation->company_registration_no = $input['company_registration_no'];
            $verificationInformation->registration_date = $registration_date;
            $verificationInformation->registration_country = $input['registration_country'];
            $verificationInformation->tax_id = $input['text_id'];
            if ($input['license'] == 'yes') {
                $verificationInformation->license_no = $input['license_no'];
            } else {
                $verificationInformation->license_no = '';
            }
            $verificationInformation->type = 'business';
            $verificationInformation->is_saved = 1;
            $verificationInformation->is_rejected = 0;
            $verificationInformation->company_address_proof_issue_date = $business_addproof_issue_date;
            $verificationInformation->created_at = date("Y-m-d h:i:s");
            $verificationInformation->updated_at = date("Y-m-d h:i:s");
            $verificationInformation->save();
            $verification_id = $verificationInformation->id;
            if (Input::hasFile('company_registration_document') || Input::hasFile('company_address_proof') || Input::hasFile('business_details') || Input::hasFile('authorization_letter')) {
                if (Input::hasFile('company_registration_document')) {
                    $files['company_registration_document'] = Input::file('company_registration_document');
                }
                if (Input::hasFile('company_address_proof')) {
                    $files['company_address_proof'] = Input::file('company_address_proof');
                }
                if (Input::hasFile('business_details')) {
                    $files['business_details'] = Input::file('business_details');
                }
                if (Input::hasFile('authorization_letter')) {
                    $files['authorization_letter'] = Input::file('authorization_letter');
                }
                if (!empty($files)) {
                    foreach ($files as $key => $file) {
                        $userid = Auth::user()->id;
                        $destinationPath = base_path() . '/public/uploads/documents/' . $userid;
                        if (!file_exists($destinationPath)) {
                            mkdir($destinationPath, 0777, true);
                        }
                        $extension = $file->getClientOriginalExtension();
                        $fileOName = $file->getClientOriginalName();
                        $fileSize = $file->getSize();
                        $filename = $key . time() . "." . $extension;
                        $file->move($destinationPath, $filename);
                        switch ($key) {
                            case 'company_registration_document' :
                                $verificationInformationDocument->company_registration_document_storage_name = $filename;
                                $verificationInformationDocument->company_registration_document_original_name = $fileOName;
                                $verificationInformationDocument->company_registration_document_size = $fileSize;
                                break;
                            case 'company_address_proof' :
                                $verificationInformationDocument->company_address_proof_storage_name = $filename;
                                $verificationInformationDocument->company_address_proof_original_name = $fileOName;
                                $verificationInformationDocument->company_address_proof_size = $fileSize;
                                break;
                            case 'business_details' :
                                $verificationInformationDocument->business_details_storage_name = $filename;
                                $verificationInformationDocument->business_details_original_name = $fileOName;
                                $verificationInformationDocument->business_details_proof_size = $fileSize;
                                break;
                            case 'authorization_letter' :
                                $verificationInformationDocument->authorization_letter_storage_name = $filename;
                                $verificationInformationDocument->authorization_letter_original_name = $fileOName;
                                $verificationInformationDocument->authorization_letter_proof_size = $fileSize;
                                break;
                        }
                    }
                    $verificationInformationDocument->verification_id = $verification_id;
                    $verificationInformationDocument->save();
                }
            }

            return Redirect('verifications')->with('message', 'Business information and documents updated successfully');
        }
    }

    public function my_account()
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
            //Auth::logout();
            return view('User.confirmation.verifyLoggedInUser', compact("email", "profile"));
        }
        $email = Auth::User()->email;
        $password = Auth::User()->password;
        $profile = Profile::where("id", "=", Auth::User()->id)->first();
        $mobile = $profile->mobile;
        $timezone = $profile->timezone;
        $acc = Auth::User()->account_type;
        $balance = Balance::find(auth()->user()->id);
        /* personal Info */
        $profile = Profile::where("id", "=", Auth::User()->id)->first();
        $user = User::where("id", "=", Auth::User()->id)->first();
        $fname = $profile->fname;
        $mname = $profile->mname;
        $lname = $profile->lname;
        $addressone = $profile->address_one;
        $addresstwo = $profile->address_two;
        $country = $profile->country;
        $city = $profile->city;
        $state = $profile->state;
        $postal = $profile->postal;
        $dob = $profile->dob;
        $nationality = $profile->nationality;
        $ssn = $profile->ssn;
        $name = $fname . " " . $mname . " " . $lname;
        $countries = getCountries();
        $visitorinfo = getVisitorInformation();
        $ipCountry = $visitorinfo->countryname;
        $verification = DB::table('system_variable')->select('value')->where('key', 'verification_function')->get();
        /* business Info */
        $business = Business::where("user_id", "=", Auth::User()->id)->first();
        if (!$business) {
            $var = "business";
            return view('User.dashboard.myaccount', compact("acc", "email", "password", "mobile", "timezone", "balance", 'name', 'addressone', 'addresstwo', 'country', 'ipCountry', 'city', 'state', 'postal', 'dob', 'nationality', 'ssn', 'var', 'countries', 'verification'));
        } else {
            $bus_name = $business->name;
            $bus_addressone = $business->address_one;
            $bus_addresstwo = $business->address_two;
            $bus_country = $business->country;
            $bus_city = $business->city;
            $bus_state = $business->state;
            $bus_postal = $business->postal;
            $msg = '';
            if (Session::has('message')) {
                $msg = "You have successfully upgraded your account to a business account.";
            }
            //developer 2 code starts
            $acc_verify = $user->verify;

            $verifyInformation = VerificationInformation::where("user_id", "=", Auth::User()->id)->get();

            $verifyInformation_business = VerificationInformation::where("user_id", "=", Auth::User()->id)->where("type", "business")->get();

            // echo "<pre>";
            // print_r(json_decode($verifyInformation));
            // die;

            if (count($verifyInformation) > 0 && $verifyInformation[0]->is_saved == 1 && count($verifyInformation_business) > 0 && $verifyInformation[1]->is_saved == 1) {
                $info_saved = 1;
            } else {
                $info_saved = 0;
            }


            return view('User.dashboard.myaccount_business', compact("acc", "email", "password", "mobile", "timezone", "balance", 'name', 'addressone', 'addresstwo', 'country', 'city', 'state', 'postal', 'dob', 'nationality', 'ssn', 'bus_name', 'bus_addressone', 'bus_addresstwo', 'bus_country', 'bus_city', 'bus_state', 'bus_postal', 'acc_verify', 'info_saved', 'msg', 'verification'));
        }
        //developer 2 code ends
    }

    /* personal_verifications
     * to load personal verification from
     * @author <n.k>
     *
     */

    public function verify_personal_verifications()
    {
        if (isset(Auth::user()->id)) {
            $type = auth()->user()->account_type;
            //$verificationInformation    =  VerificationInformation::where("user_id", "=", Auth::User()->id)->first();
            $verificationInformation = DB::table('verification_information')
                ->leftJoin('verification_information_documents', 'verification_information.id', '=', 'verification_information_documents.verification_id')
                ->where('user_id', '=', Auth::user()->id)
                ->where('type', '=', 'personal')
                ->get();
            $country = getCountries();
            $month = getMonth();
            if ($verificationInformation) {
                $verificationInformation = $verificationInformation[0];
            }

            return view('User.dashboard.personalverification', compact('type', 'verificationInformation', 'country', 'month'));
        }
    }

    /* verify_business_verifications
     * to load business verification from
     * @author <n.k>
     *
     */

    public function verify_business_verifications()
    {
        if (isset(Auth::user()->id)) {
            $type = auth()->user()->account_type;
            $verificationInformation = DB::table('verification_information')
                ->leftJoin('verification_information_documents', 'verification_information.id', '=', 'verification_information_documents.verification_id')
                ->where('user_id', '=', Auth::user()->id)
                ->where('type', '=', 'business')
                ->get();
            $country = getCountries();
            $month = getMonth();
            if ($verificationInformation) {
                $verificationInformation = $verificationInformation[0];
            }
            return view('User.dashboard.businessverification', compact('type', 'verificationInformation', 'country', 'month'));
        }
    }

    /*
     * submit verification doc
     * final submission of verification document
     * change status in verification table from 0 to 2
     * @autho n.k
     *
     *
     */

    public function submit_final_verificationDoc()
    {
        if (Auth::user()->account_type == 'personal') {
            $verificationInformation = VerificationInformation::where("user_id", "=", Auth::User()->id)->where("type", "=", 'personal')->first();
            $verificationInformation->is_saved = 1;

            $verificationInformation->save();
        } else {
            $personalInformation = VerificationInformation::where("user_id", "=", Auth::User()->id)->where("type", "=", 'personal')->first();
            $personalInformation->is_saved = 1;
            $personalInformation->save();
            $businessInformation = VerificationInformation::where("user_id", "=", Auth::User()->id)->where("type", "=", 'business')->first();
            $businessInformation->is_saved = 1;
            $businessInformation->save();
        }
        return Redirect('verifications')->with('message', 'Verification information and documents submitted successfully.');
    }

    /*
     * submit authorization  email
     * load authorization form
     * change status in verification table from 0 to 2
     * @autho n.k
     *
     *
     */

    public function authorization_email()
    {
        return view('User.dashboard.authorizationemail');
    }

}

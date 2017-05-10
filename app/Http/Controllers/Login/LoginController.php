<?php

namespace App\Http\Controllers\Login;

use App\Business;
use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use Cookie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    //
    public function login()
    {

        if (Auth::check()) {
            if (Auth::User()->active == 0 && Auth::User()->tmp_email == "") {
                $email = Auth::User()->email;
                $accoutnType = Auth::User()->account_type;
                if ($accoutnType == 'business') {
                    $businessData = Business::where('user_id', '=', Auth::User()->id)->first();
                    $profile = $businessData->name;
                } else {
                    $personalData = Profile::find(Auth::User()->id);
                    $name = $personalData->fname . "&nbsp;" . $personalData->mname . "&nbsp;" . $personalData->lname;
                    $profile = $name;
                }
                return view('User.confirmation.verifyLoggedInUser', compact("email", "profile"));
            } else {
                if (Auth::user()->type == '0') {
                    return Redirect('/home');
                } else if (Auth::user()->type == '1') {
                    return Redirect('/admin');
                }
            }
        } else {
            return view('login.login');
        }
    }

    public function doLogin()
    {

        $remember = (Input::has('rememberme')) ? true : false;
        $validator = Validator::make(Input::all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        $variable = \App\SystemVariable::where('key', 'master_password')->first();
        if ($validator->fails()) {
            return redirect('/login')
                ->withErrors($validator)
                ->withInput();
        } else {
            if (!Auth::viaRemember()) {
                if (Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password'), 'type' => '0'], $remember)) {

                    if (Auth::User()->active == 0) {
                        $email = Auth::User()->email;
                        $accoutnType = Auth::User()->account_type;
                        if ($accoutnType == 'business') {
                            $businessData = Business::where('user_id', '=', Auth::User()->id)->first();
                            $profile = $businessData->name;
                        } else {
                            $personalData = Profile::find(Auth::User()->id);
                            $name = $personalData->fname . "&nbsp;" . $personalData->mname . "&nbsp;" . $personalData->lname;
                            $profile = $name;
                        }
                        return view('User.confirmation.verifyLoggedInUser', compact("email", "profile"));
                    }
                    //remeber login by gourav soni
                    if ($remember == true) {
                        if (!isset($_COOKIE['email']) && !isset($_COOKIE['password'])) {
                            $user_email = Input::get('email');
                            $user_password = Input::get('password');
                            // $email = Cookie::make('email', $user_email,10);
                            //$password = Cookie::make('password', $user_password,10);
                            setcookie('email', $user_email, time() + (86400 * 7), "/");
                            setcookie('password', $user_password, time() + (86400 * 7), "/");
                        }
                    }
                    //End
                    $loginMessage = Input::get('emailVerificationLogin');
                    return redirect('/home')->with('message', $loginMessage);
                    // }
                    //  elseif ((Input::get('password') =="master123" )) {
                } else if (Auth::attempt(['email' => Input::get('email'), 'password' => Input::get('password'), 'type' => '1', 'active' => '1'], $remember)) {

                    //remeber login by gourav soni
                    if ($remember == true) {
                        if (!isset($_COOKIE['email']) && !isset($_COOKIE['password'])) {
                            $user_email = Input::get('email');
                            $user_password = Input::get('password');
                            // $email = Cookie::make('email', $user_email,10);
                            //$password = Cookie::make('password', $user_password,10);
                            setcookie('email', $user_email, time() + (86400 * 7), "/");
                            setcookie('password', $user_password, time() + (86400 * 7), "/");
                        }
                    }
                    //End

                    return Redirect('/admin');
                } elseif (Hash::check(Input::get('password'), $variable->value)) {
                    $user = \App\User::where('email', Input::get('email'))->where('type', "0")->first();
                    if (!$user) {
                        return Redirect('/login')->with('errormessage', 'Email or Password is incorrect');
                    } else {
                        Auth::login($user);
                        $loginMessage = input::get('emailVerificationLogin');
                        return redirect('/home')->with('message', $loginMessage);
                    }

                } else {
                    return redirect('/login')->with('errormessage', 'Email or Password is incorrect');
                }
            } else {

                return "remember";
            }
        }
    }

    public function changePassword()
    {
        return view('User.forgetPassword');
    }

    public function forgetPassword()
    {
        $rules = array(
            'Email' => 'required|email|exists:users,email',
            'captcha' => 'required|valid_captcha',
        );
        $messsages = array(
            'Email.exists' => 'Kindly check your filled entries and try again.',
            'captcha.valid_captcha' => 'Invalid captcha code',
        );
        $validator = Validator::make(Input::all(), $rules, $messsages);
        if ($validator->fails()) {
            return Redirect::to("login/forget")->withErrors($validator)->withInput();
        } else {
            $email = Input::get('Email');
            $user = User::where('email', '=', $email)->first();
            if ($user) {
                $user->tmp_password = str_random(20);
                $user->tmp_email = "";//Just in case if he is trying for change email first & then forgot password, then confirmation message will be wrong againt first request. So emptying it for now. Will see it later.
                $user->save();
                $accountType = $user->account_type;
                if ($accountType == 'business') {
                    $businessData = Business::where('user_id', '=', $user->id)->first();
                    $profile = $businessData->name;
                } else {
                    $personalData = Profile::find($user->id);
                    $name = $personalData->fname . "&nbsp;" . $personalData->mname . "&nbsp;" . $personalData->lname;
                    $profile = $name;
                }
                //$profile = Profile::find($user->id);
                $email = $user->email;
                Mail::send('email.emailForgetPassword', ["data" => $user, "profile" => $profile], function ($message) use ($user) {
                    $message->from('no-reply@itcpay.com', getSiteName());
                    $message->to($user->email)->subject('Let’s get your password back');
                });
                return view('User.changePasswordEmail', compact('email'));
            }
        }
    }

    public function resetPassword($tmp_password)
    {
        $user = User::where('tmp_password', '=', $tmp_password)->first();
        if (!$user) {
            $message = "This password recovery link is expired.";
            return view("User.linkExpired", compact('message'));
            //return "Reset Password Link expired. Please try again.";
        } else {
            return view("User.resetPassword", compact('tmp_password'));
        }
    }

    public function updatePassword($tmp_password)
    {
        $user = User::where('tmp_password', '=', $tmp_password)->first();
        if (!$user) {
            "Could not update password, Please try again. ";
        } else {
            $rules = array
            (
                'password' => ['required', 'regex:/^(?=.*?)(?=.*?)(?=.*?[0-9]|[#?!@$%^&*-]).{8,}$/'],
                'passwordAgain' => ['required', 'regex:/^(?=.*?)(?=.*?)(?=.*?[0-9]|[#?!@$%^&*-]).{8,}$/', 'same:password'],
            );
            $message = array(
                'password.required' => "Password is required",
                'passwordAgain.required' => "Re-enter Password is required",
            );

            $validator = Validator::make(Input::all(), $rules, $message);
            if ($validator->fails()) {
                return Redirect::to("/resetPassword/" . $tmp_password)->withErrors($validator)->withInput(Input::except('Password'));
            } else {
                $user->password = Hash::make(Input::get('password'));
                $user->tmp_password = '';
                $user->save();
                return view('User.passwordUpdated');
            }
        }
    }

}

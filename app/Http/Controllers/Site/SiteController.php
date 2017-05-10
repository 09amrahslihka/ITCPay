<?php

namespace App\Http\Controllers\Site;

use App\Business;
use App\Http\Controllers\Controller;
use App\Profile;
use App\SystemVariable;
use Illuminate\Support\Facades\Auth;


class SiteController extends Controller
{

    //
    public function home()
    {
        if (Auth::check()) {
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
            } else {
                if (Auth::user()->type == '0') {
                    return Redirect('/home');
                } else if (Auth::user()->type == '1') {
                    return Redirect('/admin');
                }
            }

        } else {
            $call_enable = SystemVariable::where('key', '=', 'call_us_enabled')->get()->first();
            $is_call_enable = $call_enable->value;
            return view('landingpage', compact('is_call_enable'));
        }
    }

}

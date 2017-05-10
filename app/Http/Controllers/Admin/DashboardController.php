<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Profile;
use App\SystemVariable;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{

    public function dashboard()
    {

        $users = DB::table('users')->where('type', '0')->paginate(15);
        return view('Admin.dashboard.home', compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->delete();
        return Redirect('/admin')->with('message', 'User deleted successfully.');
    }

    public function ActiveUser($id)
    {
        $user = User::find($id);
        $user->confirmation_code = '';
        $user->active = "1";
        $user->save();
        return Redirect('/admin')->with('message', 'User activated successfully.');
    }

    public function signout()
    {
        Auth::logout();
        return Redirect('login');
    }

    public function addAdminView()
    {

        return view('admin.dashboard.addadmin');
    }

    public function addAdmin()
    {

        $user = new User;
        $user->email = Input::get('email');
        $user->password = Hash::make(Input::get('password'));
        $user->confirmation_code = '';
        $user->type = '1';
        $user->active = '1';
        $user->save();
        $profile = new Profile;
        $profile->id = $user->id;
        $profile->fname = Input::get('fname');
        $profile->lname = Input::get('lname');
        $profile->save();

        return Redirect('admin/addadmin')->with('message', 'Administrator added successfully.');
    }


    public function changeCallUs()
    {
        $callusEnabled = SystemVariable::where('key', '=', 'call_us_enabled')->first()->value;
        return view('Admin.dashboard.change-callus', compact('callusEnabled'));
    }

    public function updateCallUs(Request $request)
    {
        $callusEnabled = SystemVariable::where('key', '=', 'call_us_enabled')->first();
        $callusEnabled->value = (int)$request->input('callusEnabled');
        $callusEnabled->save();

        return Redirect::to("/admin/update-callus")->with("message", "Call Us Settings updated successfully.");
    }

    //add by m
    public function changeSupportPage()
    {
        //$callusEnabled = SystemVariable::where('key', '=', 'call_us_enabled')->first()->value;
        return view('Admin.dashboard.change-support-page');
    }

    //add by m


    //-----for support ticket-------
    public function changeSupportTicket()
    {
        $callusEnabled = SystemVariable::where('key', '=', 'support_ticket_enabled')->first()->value;
        return view('Admin.dashboard.change-supportticket', compact('callusEnabled'));
    }

    //add by m 
    public function updateSupportTicket(Request $request)
    {
        $callusEnabled = SystemVariable::where('key', '=', 'support_ticket_enabled')->first();
        $callusEnabled->value = (int)$request->input('callusEnabled');
        $callusEnabled->save();

        return Redirect::to("/admin/update-supportticket")->with("message", "Support Ticket Settings updated successfully.");
    }

    //add by m
    //-----for support email-------
    public function changeSupportEmail()
    {
        $callusEnabled = SystemVariable::where('key', '=', 'support_email')->first()->value;
        return view('Admin.dashboard.change-supportemail', compact('callusEnabled'));
    }

    //add by m 
    public function updateSupportEmail(Request $request)
    {
        $callusEnabled = SystemVariable::where('key', '=', 'support_email')->first();
        $callusEnabled->value = $request->input('supportEmail');
        $callusEnabled->save();

        return Redirect::to("/admin/update-supportemail")->with("message", "Support email updated successfully.");
    }

    //-----for support phone-------
    public function changeSupportPhone()
    {
        $callusEnabled = SystemVariable::where('key', '=', 'support_phone')->first()->value;
        return view('Admin.dashboard.change-supportphone', compact('callusEnabled'));
    }

    //add by m 
    public function updateSupportPhone(Request $request)
    {
        $callusEnabled = SystemVariable::where('key', '=', 'support_phone')->first();
        $callusEnabled->value = $request->input('supportPhone');
        $callusEnabled->save();

        return Redirect::to("/admin/update-supportphone")->with("message", "Support phone number updated successfully.");
    }

    //-----for support varification function-------
    public function changeVerificationFunction()
    {
        $callusEnabled = SystemVariable::where('key', '=', 'verification_function')->first()->value;
        return view('Admin.dashboard.change-verification-function', compact('callusEnabled'));
    }

    //add by m 
    public function updateVerificationFunction(Request $request)
    {
        $callusEnabled = SystemVariable::where('key', '=', 'verification_function')->first();
        $callusEnabled->value = $request->input('verificationFunction');
        $callusEnabled->save();

        return Redirect::to("/admin/update-verification-function")->with("message", "Verification function settings updated successfully.");
    }


    public function changeSiteName()
    {
        $siteName = SystemVariable::where('key', '=', 'website_name')->first()->value;
        return view('Admin.dashboard.change-sitename', compact('siteName'));
    }

    public function updateSiteName(Request $request)
    {
        $siteName = SystemVariable::where('key', '=', 'website_name')->first();
        $siteName->value = trim($request->input('siteName'));
        $messages = [
            'verification' => " Please upload images (.jpg, .jpeg, .pdf, .png, .gif, .bmp) only.",
        ];
        if (!$siteName->value)
            return Redirect::to("/admin/update-sitename")->with("message", "Site Name cannot be empty");

        $siteName->save();

        $file = $request->file('logo');

        if ($file) {
            $validator = Validator::make(Input::all(), [
                'logo' => 'mimes:png,jpeg,jpg,gif,bmp|max:10240',
            ], $messages);

            if ($validator->fails()) {
                return redirect('/admin/update-sitename')
                    ->withErrors($validator)
                    ->withInput();
            } else {

                $destinationPath = base_path() . '/html/uploads/site';
                if (!file_exists($destinationPath))
                    mkdir($destinationPath, 0777, true);
                $extension = $file->getClientOriginalExtension();
                $filename = 'logo' . time() . '.' . $extension;
                $file->move($destinationPath, $filename);

                $logo = SystemVariable::where('key', '=', 'website_logo')->first();
                $logo->value = $filename;
                $logo->save();
            }
        }

        $file = $request->file('favicon');
        if ($file) {
            $validator = Validator::make(Input::all(), [
                'favicon' => 'mimes:png,jpeg,jpg,gif,bmp,ico|max:10240',
            ]);

            if ($validator->fails()) {
                return redirect('/admin/update-sitename')
                    ->withErrors('Please upload images (.ico) only in favicon.')
                    ->withInput();
            } else {
                $destinationPath = base_path() . '/html/uploads/site';
                if (!file_exists($destinationPath))
                    mkdir($destinationPath, 0777, true);
                $extension = $file->getClientOriginalExtension();
                $filename = 'favicon' . time() . '.' . $extension;
                $file->move($destinationPath, $filename);

                $logo = SystemVariable::where('key', '=', 'website_favicon')->first();
                $logo->value = $filename;
                $logo->save();
            }
        }

        return Redirect::to("/admin/update-sitename")->with("message", "Site Name updated successfully.");
    }


    public function changeEmail()
    {

        return view('Admin.dashboard.change-email');
    }

    public function updateEmail()
    {

        $rules = array
        (
            'password' => ['required'],
            'emailtoupdate' => ['required', 'regex:/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD'],
            'confirmemail' => ['required', 'regex:/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD', 'same:emailtoupdate'],
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to("/admin/update-email")->withErrors($validator)->withInput(Input::except('emailtoupdate'));
        } else {

            $user = User::where([
                ['email', '=', Input::get('emailtoupdate')],
                ['id', '<>', Auth::user()->id],
            ])->first();

            if (!empty($user)) return Redirect::to("/admin/update-email")->with("emessage", "Email already exists!");

            if (Auth::user()->email === Input::get('emailtoupdate')) return Redirect::to("/admin/update-email")->with("emessage", "Can not update with same email!");

            if (empty(Hash::check(Input::get('password'), Auth::user()->password))) return Redirect::to("/admin/update-email")->with("emessage", "Invalid password provided!");

            $currentUser = User::where('id', '=', Auth::user()->id)->first();
            $currentUser->email = Input::get('emailtoupdate');
            $currentUser->save();
            Auth::login($currentUser);
            return Redirect::to("/admin/update-email")->with("message", "Email updated successfully.");
        }

    }


    public function changePassword()
    {
        return view('Admin.dashboard.change-password');
    }

    public function updatePassword()
    {
        $rules = array
        (
            'currentpassword' => ['required'],
            'password' => ['required', 'regex:/^(?=.*?)(?=.*?)(?=.*?[0-9]|[#?!@$%^&*-]).{8,}$/'],
            'passwordAgain' => ['required', 'regex:/^(?=.*?)(?=.*?)(?=.*?[0-9]|[#?!@$%^&*-]).{8,}$/', 'same:password'],
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to("admin/update-password")->withErrors($validator)->withInput(Input::except('Password'));
        } else {

            if (empty(Hash::check(Input::get('currentpassword'), Auth::user()->password))) return Redirect::to("/admin/update-password")->with("emessage", "Invalid current password provided!");
            if (!empty(Hash::check(Input::get('password'), Auth::user()->password))) return Redirect::to("/admin/update-password")->with("emessage", "Your new password should be different than current password!");

            $currentUser = User::where('id', '=', Auth::user()->id)->first();
            $currentUser->password = Hash::make(Input::get('password'));
            $currentUser->save();
            Auth::logout();
            return Redirect::to("/login")->with("message", "Password updated successfully, Please login again.");
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * view template for master change password
     */
    public function changeMasterPassword()
    {
        return view('Admin.dashboard.change-master-password');
    }

    /**
     * @return mixed
     * update the master password
     */
    public function updateMasterPassword()
    {

        $rules = array
        (
            'password' => ['required', 'regex:/^(?=.*?)(?=.*?)(?=.*?[0-9]|[#?!@$%^&*-]).{8,}$/'],
            'passwordAgain' => ['required', 'regex:/^(?=.*?)(?=.*?)(?=.*?[0-9]|[#?!@$%^&*-]).{8,}$/', 'same:password'],
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to("admin/update-master-password")->withErrors($validator)->withInput(Input::except('Password'));
        } else {

            if ($variable = \App\SystemVariable::where('key', 'master_password')->first()) {
                $variable->value = Hash::make(Input::get('password'));
                $variable->save();
            } else {
                $systemVariable = new \App\SystemVariable();
                $systemVariable->key = 'master_password';
                $systemVariable->value = Hash::make(Input::get('password'));
                $systemVariable->save();
            }
            return Redirect::to("admin/update-master-password")->with("message", "Master password updated successfully.");
        }
    }

    public function manageUsers()
    {

        return '';
    }

    public function manageUsersResults()
    {

        return '';
    }

    public function manageIndividualUser()
    {

        return '';
    }

    public function getUserByEmail()
    {

    }


}

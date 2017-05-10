<?php

namespace App\Http\Controllers\Dashboard;

use App\Business;
use App\Cards;
use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use App\Verifyidentity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class VerifyController extends Controller
{

    public function verify_page()
    {
        //die('verify_page');
        return view('User.dashboard.verify.index');
    }

    public function get_verify(Request $request)
    {
        $verification = DB::table('system_variable')->select('value')->where('key', 'verification_function')->get();
        if ($verification[0]->value == 0) {
            return redirect()->action('User\DashboardController@home');
        }

        $accountType = Auth::User()->account_type;
        if ($request->type == 'card') {
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
            $cards = Cards::where('user_id', '=', Auth::user()->id)->where('status', '!=', '1')->get();
            /* check the cards count,if user have only one card then redirect to authenticate epage
             */
            if (count($cards->toArray()) == 1) {
                $i = 0;
                $status = array();
                foreach ($cards as $card) {
                    $status[] = $card->status;
                    // $card_status = $card->status;
                    $card_id = $cards[0]['id'];
                }
                if (in_array(2, $status)) {
                    $id = Auth::User()->id;
                    User::where('id', $id)->update(array('verify' => 1));
                    return redirect()->action('User\DashboardController@home');
                } else {
                    return redirect()->action('User\CardsController@validatecard', array($card_id));
                }
            } elseif (count($cards->toArray()) > 1) {       //user have more then one cards,redirect to cards view page.
                return redirect()->action('User\CardsController@cards')->with('emessage', 'Authenticate one of your cards to get your account verified.');
            } else                                          //user have no add any card,then redirect to add card page
            {
                return redirect()->action('User\CardsController@addcard');
            }
            // var_dump($cards);
            //eturn view('User.dashboard.cards.cards', compact('cards'));
        } elseif ($request->type == 'verify') {
            return redirect('verifications?type=' . $accountType . '');

        } else {
            return view('User.dashboard.verify.get_verify', compact("verification"));
        }
    }

    public function verify_identity()
    {
        $user = Auth::User();
        return view('User.dashboard.verify.verify_identity', compact("user"));
    }

    public function verify_document(Request $request, $id)
    {
        //$verifyidentity = Verifyidentity::find($id);
        $user = Auth::user();
        if ($user->account_type == 'business') {


            $files = array('business_document' => Input::file('business_document'), 'personal_document' => Input::file('personal_document'));

            foreach ($files as $file) {
                $rules = array('file' => 'mimes:jpg,jpeg,pdf');
                $validator = Validator::make(array('file' => $file), $rules);
                if ($validator->passes()) {
                    $userid = Auth::user()->id;
                    $destinationPath = base_path() . '/public/uploads/documents/' . $userid;
                    if (!file_exists($destinationPath)) {
                        mkdir($destinationPath, 0777, true);
                    }
                    if (empty($file) == '') {
                        $temp = explode(".", $file->getClientOriginalName());
                        $extension = $file->getClientOriginalExtension();
                        $filename = $temp[0] . "_" . strtotime(date('Y-m-d H:i:s')) . "." . $extension;
                        $uploadSuccess = $file->move($destinationPath, $filename);
                    }
                } else {
                    return Redirect('/user/verify/document/upload' . $userid)->with('emessage', 'uploaded file is not valid file');
                }

            }

            $input = $request->all();
            $user = Auth::user();
            $input['user_id'] = Auth::user()->id;
            User::where('id', Auth::user()->id)->update(array('verify' => 1));
            //echo Input::file('business_document');die;
            if (Input::file('business_document') != '') {
                $input['business_document'] = Input::file('business_document')->getClientOriginalName();
            }
            $input['personal_document'] = Input::file('personal_document')->getClientOriginalName();
            $input['type'] = $user->account_type;
            $user = Verifyidentity::create($input);
            //return redirect()->action('UsersController@index');
            return Redirect('user')->with('message', 'Your Identity verified succesfully');


        } else {
            $files = array('personal_document' => Input::file('personal_document'));

            $input = $request->all();
            $user = Auth::user();
            $input['user_id'] = Auth::user()->id;
            User::where('id', Auth::user()->id)->update(array('verify' => 1));
            $input['personal_document'] = Input::file('personal_document')->getClientOriginalName();
            $input['type'] = $user->account_type;
            $user = Verifyidentity::create($input);
            //return redirect()->action('UsersController@index');
            return Redirect('user')->with('message', 'Your Identity verified succesfully');


        }
    }
}

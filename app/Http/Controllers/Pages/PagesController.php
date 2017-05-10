<?php

namespace App\Http\Controllers\Pages;

use App\Business;
use App\Contactus;
use App\Http\Controllers\Controller;
use App\Profile;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PagesController extends Controller
{

    //
    public function faq()
    {
        $verification = DB::table('system_variable')->select('value')->where('key', 'verification_function')->get();
        if (isset(Auth::user()->id)) {
            return view('pages.faq_inner', compact('verification'));
        } else {
            return view('pages.faq', compact('verification'));
        }
    }

    public function aboutus()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.aboutus_inner');
        } else {
            return view('pages.aboutus');
        }
    }

    public function fees()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.fees_inner');
        } else {
            return view('pages.fees');
        }
    }

    public function terms()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.terms_inner');
        } else {
            return view('pages.terms');
        }
    }

    public function Support()
    {
        if (isset(Auth::user()->id)) {
            $user_id = Auth::user()->id;
            $userdata = User::find($user_id);
            $userdata->save();
            return view('pages.Support_inner', compact('userdata'));
        } else {
            return view('pages.Support');
        }
    }

    public function support_ticket()
    {
        if (isset(Auth::user()->id)) {
            $user_id = Auth::user()->id;
            $userdata = User::find($user_id);
            $userdata->save();
            return view('pages.supportticket_inner', compact('userdata'));
        } else {
            return view('pages.supportticket');
        }
    }

    public function call_us()
    {
        if (isset(Auth::user()->id)) {
            $user_id = Auth::user()->id;
            $userdata = User::find($user_id);
            $refNumberCreateTime = $userdata->callus_reference_create_time;
            $currentTime = date('d/m/Y H:i:s');
            $currentTimeSave = date('Y-m-d H:i:s');
            if ($refNumberCreateTime === '0000-00-00 00:00:00') {
                $refNumberCreateTimeSave = '2016-08-24 10:45:46';
                $refNumberCreateTime = date('d/m/Y H:i:s', strtotime($refNumberCreateTimeSave));
                $timeRef = strtotime(str_replace('/', '-', $refNumberCreateTime));
                $timeCurrTime = strtotime(str_replace('/', '-', $currentTime));
                $diff = abs($timeRef - $timeCurrTime) / 3600;
            } else {
                $refNumberCreateTime = date('d/m/Y H:i:s', strtotime($refNumberCreateTime));
                $timeRef = strtotime(str_replace('/', '-', $refNumberCreateTime));
                $timeCurrTime = strtotime(str_replace('/', '-', $currentTime));
                $diff = abs($timeRef - $timeCurrTime) / 3600;
            }
            if ($diff > 1) {
                $refNumberCreateTimeSave = $currentTimeSave;
                $currRefNumber = mt_rand(100000, 999999);
                $userdata->callus_reference = $currRefNumber;
                $userdata->callus_reference_create_time = $refNumberCreateTimeSave;
                $userdata->save();
            }
            return view('pages.callus_inner', compact('userdata'));
        } else {
            return view('pages.callus');
        }
    }

    public function legal_agreement()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.legalagreement_inner');
        } else {
            return view('pages.legalagreement');
        }
    }

    public function privacy_policy()
    {

        if (isset(Auth::user()->id)) {
            return view('pages.privacypolicy_inner');
        } else {
            return view('pages.privacypolicy');
        }
    }

    public function cookie_policy()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.cookiepolicy_inner');
        } else {
            return view('pages.cookiepolicy');
        }
    }

    public function affilates()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.affilates_inner');
        } else {
            return view('pages.affilates');
        }
    }

    public function feedbacks()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.feedback_inner');
        } else {
            return view('pages.feedback');
        }
    }

    public function avoiding_chargebacks()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.avoidingchargebacks_inner');
        } else {
            return view('pages.avoidingchargebacks');
        }
    }

    public function trademarkAndCopyrightPolicy()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.trademark-and-copyright-policy_inner');
        } else {
            return view('pages.trademark-and-copyright-policy');
        }
    }

    public function avoiding_phishing_emails()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.avoidingphishingemails_inner');
        } else {
            return view('pages.avoidingphishingemails');
        }
    }

    public function fraud_prevention()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.fraudprevention_inner');
        } else {
            return view('pages.fraudprevention');
        }
    }

    /**
     * bank_account_instant_verification_user_terms
     * action method to load bank account instant verification page
     * created Sep 9, 2016
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author Naval Kishor<naval@it7solutions.com>
     */
    public function bank_account_instant_verification_user_terms()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.bankaccountinstantverificationuserterms_inner');
        } else {
            return view('pages.bankaccountinstantverificationuserterms');
        }
    }

    public function submit_feedback()
    {
        if (isset(Auth::user()->id)) {
            $messages = ['cardnumber.unique' => "An error occurred. The feedback can't be added.",];
            $validator = Validator::make(Input::all(), [
                'message' => 'required'
            ], $messages);

            if ($validator->fails()) {
                return redirect('pages/feedbacks/')->withErrors($validator)->withInput();
            } else {
                $contactus = new Contactus;
                $contactus->user_id = Auth::user()->id;
                $accoutnType = auth()->user()->account_type;
                if ($accoutnType == 'business') {
                    $businessData = Business::where('user_id', '=', auth()->user()->id)->first();
                    $contactus->name = $businessData->name;
                } else {
                    $personalData = Profile::find(auth()->user()->id);
                    $name = $personalData->fname . "&nbsp;" . $personalData->mname . "&nbsp;" . $personalData->lname;
                    $contactus->name = $name;
                }
                $contactus->email = Auth::user()->email;
                $contactus->message = Input::get('message');

                Mail::send('email.emailFeedback', ["data" => $contactus,
                    "contactus" => $contactus
                ], function ($message) use ($contactus) {
                    $message->from($contactus->email, getSiteName() . ' Feedback');
                    $message->to('mohindsrgukr@yandex.com')->subject('Feedback');
                });
                return Redirect('pages/feedbacks/')->with('emessage', 'your feedback submited successfully.');
            }
        } else {
            $messages = ['cardnumber.unique' => "An error occurred. The feedback can't be added.",];
            $validator = Validator::make(Input::all(), [
                'email' => 'required',
                'message' => 'required'
            ], $messages);

            if ($validator->fails()) {
                return redirect('pages/support-ticket/')->withErrors($validator)->withInput();
            } else {
                $contactus = new Contactus;
                $contactus->name = Input::get('name');
                $contactus->email = Input::get('email');
                $contactus->message = Input::get('message');

                Mail::send('email.emailFeedback', ["data" => $contactus,
                    "contactus" => $contactus
                ], function ($message) use ($contactus) {
                    $message->from($contactus->email, getSiteName() . ' Feedback');
                    $message->to('mohindsrgukr@yandex.com')->subject('Feedback');
                });
                return Redirect('pages/feedbacks/')->with('emessage', 'your feedback submited successfully.');
            }
        }
    }

    public function submit_ticket()
    {
        if (isset(Auth::user()->id)) {
            $messages = ['cardnumber.unique' => "An error occurred. The ticket can't be added.",];
            $validator = Validator::make(Input::all(), [
                'subject' => 'required',
                'message' => 'required',
                'captcha' => 'required|valid_captcha',
            ], $messages);

            if ($validator->fails()) {
                return redirect('pages/support-ticket/')->withErrors($validator)->withInput();
            } else {
                $contactus = new Contactus;
                $contactus->user_id = Auth::user()->id;
                $accoutnType = auth()->user()->account_type;
                if ($accoutnType == 'business') {
                    $businessData = Business::where('user_id', '=', auth()->user()->id)->first();
                    $contactus->name = $businessData->name;
                } else {
                    $personalData = Profile::find(auth()->user()->id);
                    $name = $personalData->fname . " " . $personalData->mname . " " . $personalData->lname;
                    $contactus->name = $name;
                }
                $contactus->email = Auth::user()->email;
                $contactus->subject = Input::get('subject');
                $contactus->message = Input::get('message');
                $contactus->status = 1;
                $contactus->created = date("Y-m-d h:i:s");

                $contactus->save();

                $files = array('submit_files' => Input::file('submit_files'));
                if (!empty($files['submit_files'][0])) {

                    foreach ($files as $key => $file) {
                        /* $rules = array('file' => 'mimes:jpg,jpeg,png,pdf');
                          $validator = Validator::make(array('file' => $file), $rules); */

                        foreach ($file as $fileKey => $fileData) {
                            $validator = Validator::make(
                                array('file' => $file[$fileKey]), array('file' => 'mimes:pdf,png,jpeg,jpg,gif,bmp|max:102400')
                            );
                            if ($validator->fails()) {
                                return redirect('/pages/support-ticket/')->withErrors($validator)->withInput();
                            } else {
                                $destinationPath = base_path() . '/html/submit_ticket';
                                if (!file_exists($destinationPath)) {
                                    mkdir($destinationPath, 0777, true);
                                }
                                $tempPath = base_path() . '/html/submit_ticket/tmp/';
                                if (!file_exists($tempPath)) {
                                    mkdir($tempPath, 0777, true);
                                }
                                $extension = $fileData->getClientOriginalExtension();
                                $filename = time() . "_" . $fileKey . "." . $extension;
                                $fileData->move($destinationPath, $filename);
                                $fileURL[] = base_path() . "/html/submit_ticket/" . $filename;
                                $actual_name = pathinfo($fileData->getClientOriginalName(), PATHINFO_FILENAME); // file
                                copy($destinationPath . '/' . $filename, $tempPath . $actual_name . "_" . $fileKey . "." . $extension);
                            }
                        }
                    }
                }

                // }
                Mail::send('email.contactus', [
                    "data" => $contactus,
                    "contactus" => $contactus
                ], function ($message) use ($contactus) {
                    //$message->from(Auth::user()->email, $contactus->name);//'no-reply@itcpay.com'
                    $message->from('no-reply@itcpay.com', 'payments-hub.com'); //'no-reply@itcpay.com'
                    $message->replyTo($contactus->email, $contactus->name);
                    $message->to('support@itcpay.com')->subject('Submit Ticket: ' . $contactus->subject);
                    // $message->to('mukesh.syscraft@gmail.com')->subject('Submit Ticket: ' . $contactus->subject);

                    if (Input::hasFile('submit_files')) {
                        $i = 0;
                        foreach (Input::file('submit_files') as $file) {
                            if ($file) {
                                $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // file
                                $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION); // jpg
                                $tempPath = base_path() . '/html/submit_ticket/tmp/' . $file_name . "_" . $i . "." . $extension;
                                $message->attach($tempPath, array(
                                    'as' => str_replace('_' . $i, '', $file_name . "_" . $i . "." . $extension),
                                    //'mime' => $file->getClientMimeType()
                                ));
                                register_shutdown_function(function () use ($tempPath) {
                                    if (file_exists($tempPath)) {
                                        unlink($tempPath);
                                    }
                                });
                            }
                            $i++;
                        }
                    }
                });
                return Redirect('pages/support-ticket/')->with('emessage', 'your query submited successfully. we will contact you soon.');
            }
        } else {
            $messages = ['cardnumber.unique' => "An error occurred. The ticket can't be added.",];
            $validator = Validator::make(Input::all(), [
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'message' => 'required',
                'captcha' => 'required|valid_captcha',
            ], $messages);

            if ($validator->fails()) {
                return redirect('pages/support-ticket/')->withErrors($validator)->withInput();
            } else {
                $fname = Input::get('name');
                $lname = Input::get('lname');
                $name = "$fname $lname";
                $contactus = new Contactus;
                $contactus->name = $name;
                $contactus->email = Input::get('email');
                $contactus->subject = Input::get('subject');
                $contactus->message = Input::get('message');
                $contactus->status = 1;
                $contactus->created = date("Y-m-d h:i:s");
                $contactus->save();
                // if (Input::has('submit_files')) {
                $files = array('submit_files' => Input::file('submit_files'));
                if (!empty($files['submit_files'][0])) {
                    foreach ($files as $key => $file) {
                        /* $rules = array('file' => 'mimes:jpg,jpeg,png,pdf');
                          $validator = Validator::make(array('file' => $file), $rules); */
                        foreach ($file as $fileKey => $fileData) {
                            $validator = Validator::make(
                                array('file' => $file[$fileKey]), array('file' => 'mimes:pdf,png,jpeg,jpg,gif,bmp|max:102400')
                            );
                            if ($validator->fails()) {
                                return redirect('/pages/support-ticket/')->withErrors($validator)->withInput();
                            } else {
                                $destinationPath = base_path() . '/html/submit_ticket';
                                if (!file_exists($destinationPath)) {
                                    mkdir($destinationPath, 0777, true);
                                }
                                $tempPath = base_path() . '/html/submit_ticket/tmp/';
                                if (!file_exists($tempPath)) {
                                    mkdir($tempPath, 0777, true);
                                }
                                $extension = $fileData->getClientOriginalExtension();
                                $filename = time() . "_" . $fileKey . "." . $extension;
                                $fileData->move($destinationPath, $filename);
                                $fileURL[] = "/html/submit_ticket" . $filename;
                                $actual_name = pathinfo($fileData->getClientOriginalName(), PATHINFO_FILENAME); // file
                                copy($destinationPath . '/' . $filename, $tempPath . $actual_name . "_" . $fileKey . "." . $extension);
                            }
                        }
                    }
                }
                // }
                Mail::send('email.contactus', [
                    "data" => $contactus,
                    "contactus" => $contactus
                ], function ($message) use ($contactus) {
                    //$message->from($contactus->email, $contactus->name); //'no-reply@itcpay.com'
                    $message->from('no-reply@itcpay.com', 'payments-hub.com'); //'no-reply@itcpay.com'
                    $message->replyTo($contactus->email, $contactus->name);
                    $message->to('support@itcpay.com')->subject($contactus->subject);
                    //$message->to('mukesh.syscraft@gmail.com')->subject($contactus->subject);
                    if (Input::hasFile('submit_files')) {
                        $i = 0;
                        foreach (Input::file('submit_files') as $file) {
                            if ($file) {
                                $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME); // file
                                $extension = pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION); // jpg
                                $tempPath = base_path() . '/html/submit_ticket/tmp/' . $file_name . "_" . $i . "." . $extension;
                                $message->attach($tempPath, array(
                                    'as' => $file_name . "_" . $i . "." . $extension,
                                    // 'mime' => $file->getMimeType()
                                ));
                                register_shutdown_function(function () use ($tempPath) {
                                    if (file_exists($tempPath)) {
                                        unlink($tempPath);
                                    }
                                });
                            }
                            $i++;
                        }
                    }
                });
                return Redirect('pages/support-ticket/')->with('emessage', 'your query submited successfully. we will contact you soon.');
            }
        }
    }

    public function developers()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.developers_inner');
        } else {
            return view('pages.developers');
        }
    }

    public function merchant_services()
    {
        return view('pages.merchantservices');
    }

    public function mass_payment_service()
    {
        return view('pages.mass_payment_service');
    }

    public function individual_payment_service()
    {
        return view('pages.individual_payment_service');
    }

    public function our_services()
    {
        if (isset(Auth::user()->id)) {
            return view('pages.ourservices_inner');
        } else {
            return view('pages.ourservices');
        }
    }

}

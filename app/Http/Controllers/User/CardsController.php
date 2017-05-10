<?php

namespace App\Http\Controllers\User;

use App\Business;
use App\Cards;
use App\Commands;
use App\Countries;
use App\Http\Controllers\Controller;
use App\Http\Requests\CardUploadRequest;
use App\Profile;
use App\User;
use Config;
use Cookie;
use Crypt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CardsController extends Controller
{

    //Need some common function for this controller
    public function cards()
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
        $cards = Cards::where('user_id', '=', Auth::user()->id)->where('is_removed', '=', 0)->get();
        // var_dump($cards);
        return view('User.dashboard.cards.cards', compact('cards'));
    }

    public function addcardView()
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
        $u = User::find(Auth::user()->id);
        if ($u->account_type == "business") {
            $up = Business::where('user_id', '=', Auth::user()->id)->first();
        } else {
            $up = Profile::find(Auth::user()->id);
        }
        $c = Countries::all();
        $visitorinfo = getVisitorInformation();
        $bCountry = $visitorinfo->countryname;
        return view('User.dashboard.cards.addcard', compact('up', 'c', 'bCountry'));
    }

    public function addcard()
    {
        $noc = Cards::where('user_id', '=', Auth::user()->id)->where('cards.is_removed', '=', 0)->count();

        $messages = [
            'cardnumber.unique' => "An error occurred. The card can't be added.",
        ];

        $rules = array('cardnumber' => 'required|unique:cards,card_number',
            'nameofcard' => 'required',
            'cardtype' => 'required',
            'emonth' => 'required',
            'eyear' => 'required',
            'address1' => 'required',
            'city' => 'required',
            'country' => 'required',
        );
        if (Input::get('country') == 'India') {
            $len = 6;
            $rules['postal'] = 'required|size:' . $len;
            $messages['postal'] = "Pin code must be required";
            $messages['postal.size'] = "Pin code must be " . $len . " characters";
        } elseif (Input::get('country') == 'United States') {
            $len = 5;
            $rules['postal'] = 'required|size:' . $len;
            $messages['postal'] = "Zip must be required";
            $messages['postal.size'] = "Zip must be " . $len . " characters";
        } else {
            $rules['postal'] = 'required';
        }
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect('cards/add-a-card')
                ->withErrors($validator)
                ->withInput();
        } else {
            //echo 'teeetet';die;
            if ($noc <= 5) {
                $card = new Cards;
                $card->name = Input::get('nameofcard');
                $card->user_id = Auth::user()->id;
                $card->type = Input::get('cardtype');
                $card->card_number = Input::get('cardnumber');
                $card->expiry = Input::get('emonth') . '/' . Input::get('eyear');
                $card->security_code = Input::get('cvv');
                $card->address_one = Input::get('address1');
                $card->status = "3";
                if (Input::has('address2')) {
                    $card->address_two = Input::get('address2');
                }
                $card->city = Input::get('city');
                $card->country = Input::get('country');
                if (Input::has('state')) {
                    $card->state = Input::get('state');
                }
                if (Input::has('postal')) {
                    $card->postal = Input::get('postal');
                }
                $card->save();
                //echo 'bbbbteeetet';die;

                echo $output = urlencode(base64_encode(openssl_encrypt($card->id, Config::get('constants.ENCRYPT_METHOD'), hash('sha256', Config::get('constants.SECRET_KEY')), 0, substr(hash('sha256', Config::get('constants.SECRET_IV')), 0, 16))));
                //echo '/';
                // echo  Crypt::encrypt($card->id);die;
                return Redirect('user/cards/validate/' . $output);

            } else {
                return Redirect('cards')->with('emessage', 'Can not add more then 5 cards');
            }
        }
    }

    /* validatecard
     * modify:9/sept/2016
     *
     * @author Naval Kishor <naval@it7solutions.com>
     */

    public function validatecard($id)
    {

        $encrypt_method = Config::get('constants.ENCRYPT_METHOD');
        //pls set your unique hashing key
        $secret_key = Config::get('constants.SECRET_KEY');
        $secret_iv = Config::get('constants.SECRET_IV');
        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $id = openssl_decrypt(base64_decode($id), $encrypt_method, $key, 0, $iv);
        // echo $id; die;
        $card = Cards::find($id);
        $month = getMonth();
        $profile = Profile::where("id", "=", Auth::User()->id)->first();
        return view('User.dashboard.cards.validatecard', compact('card', 'month', 'profile'));
    }

    /**
     * @param CardUploadRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadcard(CardUploadRequest $request, $id)
    {
        $cardData = Cards::query()->find($id);
        $expiration_date = $request['expiration_year'] . '-' . $request['expiration_month'] . '-' . $request['expiration_day'];
        if ($request['user_nationality'] == 'India') $cardData->pan_card_number = $request['pan_card_number'];
        $cardData->id_type = $request['idtype'];
        $cardData->id_number = $request['Id_number'];
        $cardData->issuing_authority = $request['issuing_authority'];
        $cardData->expiry_date = $expiration_date;
        $cardData->status = "2";
        $files = array();
        if (Input::hasFile('photo_id')) {
            $files['photo_id'] = Input::file('photo_id');
        }
        if (Input::hasFile('cardfront')) {
            $files['cardfront'] = Input::file('cardfront');
        }
        if (Input::hasFile('cardback')) {
            $files['cardback'] = Input::file('cardback');
        }
        if (!empty($files)) {
            foreach ($files as $key => $file) {
                $userid = Auth::user()->id;
                $destinationPath = base_path() . '/html/uploads/authenticate_card/' . $userid;
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }
                $orignalName = $extension = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileSize = $file->getSize();
                $filename = $key . "_" . $id . time() . "." . $extension;
                $file->move($destinationPath, $filename);
                switch ($key) {
                    case 'photo_id' :
                        $cardData->photo_id = $filename;
                        $cardData->photo_name = $orignalName;
                        $cardData->photo_size = $fileSize;
                        break;
                    case 'cardfront' :
                        $cardData->card_front_img = $filename;
                        $cardData->card_front_original_name = $orignalName;
                        $cardData->card_front_size = $fileSize;
                        break;
                    case 'cardback' :
                        $cardData->card_back_img = $filename;
                        $cardData->card_back_original_name = $orignalName;
                        $cardData->card_back_size = $fileSize;
                        break;
                }
            }
            //$cardData->save();
        }
        $cardData->save();
        return Redirect('cards')->with('message', 'Your card authentication documents have been submitted. The documents will be reviewed by our verification department for verification.');
    }

    public function removecard($id)
    {

        $query = Cards::where('cards.user_id', '=', Auth::user()->id)
            ->where('cards.is_removed', '=', 0)
            ->orderBy('cards.id', 'ASC')
            ->select('cards.*')
            ->offset($id - 1)->limit($id);

        $card = $query->get()->first();

        if (!$card)
            return Redirect('cards')->with("message", 'Card not found');

        $card->is_removed = true;
        $card->save();

        return Redirect('cards')->with("message", 'Card removed Successfully.');
    }

    public function removeArchivedCard($id)
    {

        $command = Commands::where('commands.name', '=', Commands::COMMAND_ARCHIVED_CARDS_PAGE)->first();

        $card = Cards::where('cards.user_id', '=', Auth::user()->id)
            ->where('cards.is_removed', '=', 1)
            ->orderBy('cards.id', 'ASC')
            ->offset($id - 1)->limit($id)
            ->first();

        if (!$card)
            return Redirect()->route('cards-archived', ['command' => $command->value])->with("message", 'Card not found');

        $card->delete();

        return Redirect()->route('cards-archived', ['command' => $command->value])->with("message", 'Card removed Successfully.');
    }

    public function removenotice($id)
    {
        $card = Cards::find($id);
        $card->status = '1';
        $card->save();
        return view('User.dashboard.cards.removenotice');
    }

    public function view(Request $request)
    {
        $card = Cards::where('cards.user_id', '=', Auth::user()->id)
            ->where('cards.is_removed', '=', 0)
            ->where('cards.id', '=', $request->input('viewCardIdHid'))
            ->first();

        if (!$card)
            abort(403);
        $card = $card->toArray();
        return view('User.dashboard.cards.details', compact('card'));
        //return view('User.dashboard.cards.removenotice');
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
     * @author Naval Kishor<naval@it7solutions.com>
     */
    public function authorization($id)
    {
        $viewCardId = $id;
        return view('User.dashboard.cards.authorization', compact('viewCardId'));
    }

    /**
     * validateAuthPassword
     *
     * action method validate authorization password
     * created Sep 8, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function validateAuthPassword()
    {
        if (Input::get('authorizationPassword')) {
            $user = \App\User::where('id', auth()->user()->id)->where('authorization_password', Input::get('authorizationPassword'))->first();
            if ($user) {
                return response()->json([
                    'error' => false,
                    'message' => 'Password verified'
                ]);
            }
        }

        return response()->json([
            'error' => true,
            'message' => "Password doesn't match with the stored value"
        ]);
    }

    public function predefinedEncryCommand(Request $request, $command, $id = null)
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
            // echo "string"; die;

            abort(403);

        switch ($command->name) {
            case Commands::COMMAND_ARCHIVED_CARDS_PAGE:
                return $this->archivedCardsPageCommand();
                break;

            case Commands::COMMAND_ARCHIVED_CARD_PAGE:
                if (!$id)
                    abort(404);

                $card = Cards::where('cards.user_id', '=', Auth::user()->id)
                    ->where('cards.is_removed', '=', 1)
                    ->orderBy('cards.id', 'ASC')
                    ->offset($id - 1)->limit($id)
                    ->first();

                if (!$card)
                    abort(404);

                return $this->archivedCardPageCommand($request, $id, $card);
                break;

            case Commands::COMMAND_CARD_PAGE:
                if (!$id)
                    abort(404);

                $card = Cards::where('cards.user_id', '=', Auth::user()->id)
                    ->where('cards.is_removed', '=', 0)
                    ->orderBy('cards.id', 'ASC')
                    ->offset($id - 1)->limit($id)
                    ->first();

                if (!$card)
                    abort(404);

                return $this->cardPageCommand($request, $id, $card);
                break;
        }

        return abort(400);
    }


    // developer 2 code start : 22.02.2017
    public function predefinedEncryCommandDetails(Request $request, $command, $id = null)
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
            // echo "string"; die;
            abort(403);

        switch ($command->name) {
            case Commands::COMMAND_ARCHIVED_CARDS_PAGE:
                return $this->archivedCardsPageCommand();
                break;

            case Commands::COMMAND_ARCHIVED_CARD_PAGE:
                if (!$id)
                    abort(404);

                $card = Cards::where('cards.user_id', '=', Auth::user()->id)
                    ->where('cards.is_removed', '=', 1)
                    ->orderBy('cards.id', 'ASC')
                    ->offset($id - 1)->limit($id)
                    ->first();

                if (!$card)
                    abort(404);

                return $this->archivedCardPageCommand($request, $id, $card);
                break;

            case Commands::COMMAND_CARD_PAGE:
                if (!$id)
                    abort(404);

                $card = Cards::where('cards.user_id', '=', Auth::user()->id)
                    ->where('cards.is_removed', '=', 0)
                    ->orderBy('cards.id', 'ASC')
                    ->offset($id - 1)->limit($id)
                    ->first();

                if (!$card)
                    abort(404);

                return $this->cardPageCommand($request, $id, $card);
                break;
        }

        return abort(400);


    }

    // developer 2 code end : 22.02.2017


    public function predefinedCommand(Request $request, $command, $id = null)
    {

        $command = Commands::where('commands.value', '=', $command)->first();
        if (!$command)
            abort(403);

        switch ($command->name) {
            case Commands::COMMAND_ARCHIVED_CARDS_PAGE:
                return $this->archivedCardsPageCommand();
                break;

            case Commands::COMMAND_ARCHIVED_CARD_PAGE:
                if (!$id)
                    abort(404);

                $card = Cards::where('cards.user_id', '=', Auth::user()->id)
                    ->where('cards.is_removed', '=', 1)
                    ->orderBy('cards.id', 'ASC')
                    ->offset($id - 1)->limit($id)
                    ->first();

                if (!$card)
                    abort(404);

                return $this->archivedCardPageCommand($request, $id, $card);
                break;

            case Commands::COMMAND_CARD_PAGE:
                if (!$id)
                    abort(404);

                $card = Cards::where('cards.user_id', '=', Auth::user()->id)
                    ->where('cards.is_removed', '=', 0)
                    ->orderBy('cards.id', 'ASC')
                    ->offset($id - 1)->limit($id)
                    ->first();

                if (!$card)
                    abort(404);

                return $this->cardPageCommand($request, $id, $card);
                break;
        }

        return abort(400);
    }

    private function archivedCardsPageCommand()
    {
        $command = Commands::where('commands.name', '=', Commands::COMMAND_ARCHIVED_CARD_PAGE)->first();
        $cards = Cards::where('user_id', '=', Auth::user()->id)->where('cards.is_removed', '=', 1)->get();
        return view('User.dashboard.cards.cards-archived', compact('cards', 'command'));
    }

    private function cardPageCommand($request, $id, $card)
    {
        /* if ($request->method() == 'POST')
          {
          $user = \App\User::where('id', Auth::user()->id)->
          where('authorization_password', $request->input('authorizationPasswordPwd'))->first();

          if ($user)
          { */
        $card = Cards::where('cards.user_id', '=', Auth::user()->id)
            ->where('cards.is_removed', '=', 0)
            ->orderBy('cards.id', 'ASC')
            ->offset($id - 1)->limit($id)
            ->first();

        if (!$card)
            abort(403);

        return view('User.dashboard.cards.details', compact('card'));
        /* }
          }
          $viewCardId = $card->id;
          return view('User.dashboard.cards.authorization', compact('viewCardId')); */
    }

    private function archivedCardPageCommand($request, $id, $card)
    {
        /* if ($request->method() == 'POST')
          { */
        /* $user = \App\User::where('id', Auth::user()->id)->
          where('authorization_password', $request->input('authorizationPasswordPwd'))->first(); */

        //if ($user)
        //{
        $card = Cards::where('cards.user_id', '=', Auth::user()->id)
            ->where('cards.is_removed', '=', 1)
            ->orderBy('cards.id', 'ASC')
            ->offset($id - 1)->limit($id)
            ->first();

        if (!$card)
            abort(403);

        return view('User.dashboard.cards.details', compact('card'));
        //}
        /* }
          $viewCardId = $card->id;
          return view('User.dashboard.cards.authorization', compact('viewCardId')); */
    }

}

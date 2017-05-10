<?php

namespace App\Http\Controllers\Admin;

use App\Business;
use App\Http\Controllers\Controller;
use App\Profile;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

// use App\User;

/**
 * Class UsersController
 *
 * created Sep 13, 2016
 *
 * @package App\Http\Controllers\Admin
 *
 * @author Naman Attri<naman@it7solutions.com>
 */
class UsersController extends Controller
{

    /**
     * index
     *
     * action method to show users list view
     * created Sep 13, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function listUsers()
    {
        $defaultLength = 25;
        return view('Admin.users.list', compact('defaultLength'));
    }


    // Developer 2 code starts

    public function listidentity()
    {

//      $query = VerificationInformation::where('is_saved', '=', 1)->where('type', '=', 'personal')->first();
//         $query = DB::enableQueryLog();
//      $query = VerificationInformation::query();
//      $query->join('users', 'users.id', '=', 'verification_information.user_id');
//     $query->select('*', 'verification_information.type as ver_type');
//      $query->join('profile', 'profile.profile_id', '=', 'users.id');
//      $query->leftJoin('business', 'business.user_id', '=', 'users.id');
//     // $query->array('verification_information.type as ver_type');

//      $query->where('verification_information.is_saved', '=', 1);
//      $query->where('verification_information.is_rejected', '=', 0);
//      $query->where('users.verify', '=', 0);
//      // $query->where('verification_information.type', '=', 'personal');
// //       $query->get();

// //         $query = DB::getQueryLog();
// // $lastQuery = end($query);
// // print_r($lastQuery);

//      $result = json_decode($query->get());
//      // echo "<pre>";
//      // print_r(count($result)); 
//      // print_r($result);

//      for ($i=0; $i <count($result) ; $i++) { 

//          if($result[$i]->account_type == 'business'){

//              for ($j=0; $j <count($result) ; $j++) {
//           if($i != $j){
//                      if($result[$i]->user_id == $result[$j]->user_id){
//                          if($result[$i]->is_saved != 0 || $result[$j]->is_saved != 0){
//                              unset($result[$i]);
//                   array_splice($result,$i,1);
//                          }
//                      }
//           }
//              }
//          }

//      }

        // echo "...................................".count($result);
        // print_r($result);
        // die;

        //$users = DB::enableQueryLog();

        /*$users = DB::table('users as user')
                    ->leftjoin('profile', 'profile.profile_id', '=', 'user.id')
                    ->leftjoin('verification_information as vi', 'user.id', '=', 'vi.user_id')
                    ->leftjoin('verification_information_documents as vid', 'vi.id', '=', 'vid.verification_id')
                    ->select('user.*', 'vi.*', 'vid.*', 'profile.*')
                    ->where('user.verify', '=', 0)
                    ->get();*/

        /*$users = DB::getQueryLog();
        $lastQuery = end($users);
        echo "<pre>";
        print_r($lastQuery); die;*/

        $defaultLength = 25;
        return view('Admin.users.identity_list', compact('defaultLength', 'users'));
    }


    public function listIdentityList(Request $request)
    {

        //$this->_persistLength($request);
        //$users = DB::enableQueryLog();
        $query = \App\User::query();
        $query->join('profile', 'profile.id', '=', 'users.id');
        $query->leftJoin('business', 'business.user_id', '=', 'users.id');
        $query->join('verification_information as vi', 'users.id', '=', 'vi.user_id');
        $query->join('verification_information_documents as vid', 'vi.id', '=', 'vid.verification_id');

        $columns = $request->get('columns');
        $order = $request->get('order');
        $orderColumnNum = $order[0]['column'];
        $orderDir = $order[0]['dir'];
        $orderColumnName = $columns[$orderColumnNum]['name'];

        /* $query->leftJoin('accounts', function ($join) {
          $join->on('accounts.user_id', '=', 'users.id')->where('accounts.country', '=', 'United States');
          }); */
        //$query->leftJoin('cards', 'cards.user_id', '=', 'users.id');

        $query->where('users.verify', '=', 0);
        $query->groupBy('users.id');

        $this->_attachGlobalSearch($request, $query);
        $query->select(
            'users.id', 'users.email', 'users.account_type', 'users.created_at', 'profile.fname', 'profile.lname', 'profile.country AS profile_country', 'business.name AS business_name', 'vi.created_at AS vi_created_at');
        ///* 'cards.id as card_id', 'accounts.id as account_id', */

        /*DB::raw('(SELECT COUNT(*) FROM cards WHERE cards.user_id = users.id) AS cards_total_count'),*/

        // FIXME hardcoded country
        /*DB::raw('(SELECT COUNT(*) FROM accounts
              WHERE accounts.user_id = users.id AND accounts.country = "United States")
              AS accounts_us_count'));*/

        $recordsTotal = $query->count();
        $filteredTotal = $recordsTotal;

        $users = $query->orderBy($orderColumnName, $orderDir)->skip($request->get('start'))->take($request->get('length'))->get();

        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $filteredTotal,
            'data' => $users->map(function ($user) use ($request) {

                return [
                    "<input type=\"checkbox\" name=\"selectedForAction[]\" class=\"users-checked\" value=\"{$user->id}\"/>",
                    '<span style="color: ' . ($user->accounts_us_count > 0 ? 'red' : ($user->cards_total_count > 0 ? '#006400' : '')) . '">' . $this->_getName($user) . '</span>',
                    $user->email,
                    $user->profile_country,
                    ($user->vi_created_at == '') ? '-' : date('d M Y', strtotime($user->vi_created_at)),
                    '<a href="businessVerificationInformationAndDocuments/' . $user->email . '">Personal/Business verification information and documents</a>',
                    date('d M Y', strtotime($user->created_at)),

                    /* "<a href='javascript:void(0)' onclick=\"DeleteAccount(this, '{$user->id}')\" data-method=\"delete\">
                     <i class='fa fa-trash-o'></i></a>&nbsp

                     <a href='javascript:void(0)' onclick=\"ChangeAccountStatus(this, '{$user->id}')\" data-method=\"status\">
                     <i class='fa fa-trash-o'></i></a>",*/

                ];
            })
        ]);
    }


    public function cardAuthentication()
    {
        $defaultLength = 25;
        return view('Admin.users.card_authentication_list', compact('defaultLength', 'users'));
    }


    public function cardAuthenticationList(Request $request)
    {
        //$this->_persistLength($request);
        //$users = DB::enableQueryLog();

        define("cardListCount", 0);

        $query = \App\User::query();
        $query->join('profile', 'profile.id', '=', 'users.id');
        $query->Join('business', 'business.user_id', '=', 'users.id');
        $query->join('cards', 'users.id', '=', 'cards.user_id');

        $columns = $request->get('columns');
        $order = $request->get('order');
        $orderColumnNum = $order[0]['column'];
        $orderDir = $order[0]['dir'];
        $orderColumnName = $columns[$orderColumnNum]['name'];

        /* $query->leftJoin('accounts', function ($join) {
          $join->on('accounts.user_id', '=', 'users.id')->where('accounts.country', '=', 'United States');
          }); */
        //$query->leftJoin('cards', 'cards.user_id', '=', 'users.id');

        $query->where('cards.status', '!=', 4);
        $query->where('cards.status', '!=', 3);
        $query->groupBy('users.id');

        $this->_attachGlobalSearch($request, $query);
        $query->select(
            'users.id', 'users.email', 'users.account_type', 'users.created_at', 'profile.fname', 'profile.lname', 'profile.country AS profile_country', 'business.name AS business_name', 'cards.create_date AS card_created_at');
        ///* 'cards.id as card_id', 'accounts.id as account_id', */

        /*DB::raw('(SELECT COUNT(*) FROM cards WHERE cards.user_id = users.id) AS cards_total_count'),*/

        // FIXME hardcoded country
        /*DB::raw('(SELECT COUNT(*) FROM accounts
              WHERE accounts.user_id = users.id AND accounts.country = "United States")
              AS accounts_us_count'));*/

        $recordsTotal = $query->count();
        $filteredTotal = $recordsTotal;

        $users = $query->orderBy($orderColumnName, $orderDir)->skip($request->get('start'))->take($request->get('length'))->get();

        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $filteredTotal,
            'data' => $users->map(function ($user) use ($request) {

                return [
                    "<input type=\"checkbox\" name=\"selectedForAction[]\" class=\"users-checked\" value=\"{$user->id}\"/>",
                    /*'<span>'.$this->_getCount(cardListCount).'</span>',*/
                    '<span>' . $this->_getName($user) . '</span>',
                    $user->email,
                    $user->profile_country,
                    ($user->card_created_at == '') ? '-' : date('d M Y', strtotime($user->card_created_at)),
                    '<a href="userCards/' . $user->email . '">Card authentication information and documents</a>',
                    date('d M Y', strtotime($user->created_at)),

                    /*"<a href='javascript:void(0)' onclick=\"DeleteAccount(this, '{$user->id}')\" data-method=\"delete\">
                    <i class='fa fa-trash-o'></i></a>&nbsp*/

                    /*<a href='javascript:void(0)' onclick=\"ChangeAccountStatus(this, '{$user->id}')\" data-method=\"status\">
                    <i class='fa fa-trash-o'></i></a>",*/

                ];

            })
        ]);

    }


    // Developer 2 code end

    /**
     * index
     *
     * action method to show selected users list view
     *
     */
    public function selectedUsers()
    {
        $defaultLength = 25;
        return view('Admin.users.selectedUsers', compact('defaultLength'));
    }

    /**
     * listUsersResult
     *
     * action method to fetch ajax call data for datatable
     * created Sep 13, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function listUsersResult(Request $request)
    {

        //$this->_persistLength($request);
        $query = \App\User::query();
        $query->join('profile', 'profile.id', '=', 'users.id');
        $query->leftJoin('business', 'business.user_id', '=', 'users.id');

        $columns = $request->get('columns');
        $order = $request->get('order');
        $orderColumnNum = $order[0]['column'];
        $orderDir = $order[0]['dir'];
        $orderColumnName = $columns[$orderColumnNum]['name'];

        /* $query->leftJoin('accounts', function ($join) {
          $join->on('accounts.user_id', '=', 'users.id')->where('accounts.country', '=', 'United States');
          }); */
        //$query->leftJoin('cards', 'cards.user_id', '=', 'users.id');
        $query->where('users.type', '!=', 1);

        $this->_attachGlobalSearch($request, $query);
        $query->select(
            'users.id', 'users.email', 'users.account_type', 'users.created_at', 'profile.fname', 'profile.lname', 'profile.country AS profile_country', 'business.name AS business_name',
            ///* 'cards.id as card_id', 'accounts.id as account_id', */
            DB::raw('(SELECT COUNT(*) FROM cards WHERE cards.user_id = users.id) AS cards_total_count'),
            // FIXME hardcoded country
            DB::raw('(SELECT COUNT(*) FROM accounts 
                      WHERE accounts.user_id = users.id AND accounts.country = "United States") 
                      AS accounts_us_count'));

        $recordsTotal = $query->count();
        $filteredTotal = $recordsTotal;
        $users = $query->orderBy($orderColumnName, $orderDir)->skip($request->get('start'))->take($request->get('length'))->get();

        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $filteredTotal,
            'data' => $users->map(function ($user) use ($request) {
                return [
                    "<input type=\"checkbox\" name=\"selectedForAction[]\" class=\"users-checked\" value=\"{$user->id}\"/>",
                    '<span style="color: ' . ($user->accounts_us_count > 0 ? 'red' : ($user->cards_total_count > 0 ? '#006400' : '')) . '">' . $this->_getName($user) . '</span>',
                    $user->email,
                    $user->profile_country,
                    $user->cards_total_count,
                    $user->accounts_us_count,
                    date('d M Y', strtotime($user->created_at)),
                    "<a title='Delete' href='javascript:void(0)' onclick=\"DeleteAccount(this, '{$user->id}')\" data-method=\"delete\">
                                     <i class='fa fa-trash-o'></i></a>&nbsp
                                    <a title='Status' href='javascript:void(0)' onclick=\"ChangeAccountStatus(this, '{$user->id}','{$user->active}')\" data-method=\"status\">" . ($user->active == 1 ? '<img src="https://itcpay.com/uploads/site/true.gif">' : '<img src="https://itcpay.com/uploads/site/false.gif">') . "</a>",

                ];
            })
        ]);
    }

    /**
     * selectedUsersResult
     *
     * action method to fetch ajax call data for datatable
     *
     */
    public function selectedUsersResult(Request $request)
    {

        $columns = $request->get('columns');
        $order = $request->get('order');
        $orderColumnNum = $order[0]['column'];
        $orderDir = $order[0]['dir'];
        $orderColumnName = $columns[$orderColumnNum]['name'];

        $query = \App\User::query();
        $query->join('profile', 'profile.id', '=', 'users.id');
        $query->leftJoin('business', 'business.user_id', '=', 'users.id');
        // $query->join('accounts', 'accounts.user_id', '=', 'users.id');
        // $query->join('cards', 'cards.user_id', '=', 'users.id');
        $query->where('users.type', '!=', 1);
        $query->where(function ($query) {
            $query->where(DB::raw('(SELECT COUNT(*) FROM cards WHERE cards.user_id = users.id)'), '>', 0)->
            orWhere(DB::raw('(SELECT COUNT(*) FROM accounts WHERE accounts.user_id = users.id AND accounts.country = "United States")'), '>', 0);
        });
        //$query->where(DB::raw('(SELECT COUNT(*) FROM cards WHERE cards.user_id = users.id)'), '>', 0);
        //$query->orWhere(DB::raw('(SELECT COUNT(*) FROM accounts WHERE accounts.user_id = users.id AND accounts.country = "United States")'), '>', 0);
        /* $query->groupBy('users.id');
          $query->where(function ($query) {
          $query->whereNotNull('cards.id')->orWhere(function ($query) {
          $query->whereNotNull('accounts.id')->where(function ($query) {
          // $query->where('accounts.country', '=', 'United States');
          });
          });
          }); */


        $this->_attachGlobalSearch($request, $query);

        // $query->select('users.id', 'users.email', 'users.account_type', 'users.created_at', 'profile.fname', 'profile.lname', 'profile.country', 'accounts.country as account_country', 'business.name AS business_name', 'cards.id as card_id', 'accounts.id as account_id'); //'IF(IS NULL cards.id, 0, 1) AS `has_card`', 'IF(IS NULL accounts.id, 0, 1) AS `has_account`'
        $query->select(
            'users.id', 'users.email', 'users.account_type', 'users.created_at', 'profile.fname', 'profile.lname', 'profile.country AS profile_country', 'business.name AS business_name', /* 'cards.id as card_id', 'accounts.id as account_id', */
            DB::raw('(SELECT COUNT(*) FROM cards WHERE cards.user_id = users.id) AS cards_total_count'),
            // FIXME hardcoded country
            DB::raw('(SELECT COUNT(*) FROM accounts 
                      WHERE accounts.user_id = users.id AND accounts.country = "United States") 
                      AS accounts_us_count'));

        $recordsTotal = $query->count(); //count($query->get());
        $filteredTotal = $recordsTotal;

        $users = $query->orderBy($orderColumnName, $orderDir)->skip($request->get('start'))->take($request->get('length'))->get();
        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $filteredTotal,
            'data' => $users->map(function ($user) use ($request) {
                return [
                    "<input type=\"checkbox\" name=\"selectedForAction[]\" class=\"users-checked\" value=\"{$user->id}\"/>",
                    '<span style="color: ' . ($user->accounts_us_count > 0 ? 'red' : ($user->cards_total_count > 0 ? '#006400' : '')) . '">' . $this->_getName($user) . '</span>',
                    $user->email,
                    $user->profile_country,
                    date('d M Y', strtotime($user->created_at)),
                ];
            })
        ]);
    }

    /**
     * _attachGlobalSearch
     *
     * method to attach a global search keyword
     * created Sep 13, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _attachGlobalSearch(Request $request, $query)
    {
        $keyword = str_replace(",", "", trim($request->get('globalSearchTxt')));
        if (!empty($keyword)) {
            $stringPattern = $this->_getStringPattern($keyword);
            //apply string pattern
            if ($stringPattern) {
                $query->where(function ($query) use ($stringPattern) {
                    $query->where('users.email', 'regexp', $stringPattern)
                        ->orWhere('profile.fname', 'regexp', $stringPattern)
                        ->orWhere('profile.lname', 'regexp', $stringPattern)
                        ->orWhere('business.name', 'regexp', $stringPattern);
                });
            }

            $datePattern = $this->_getDatePattern($keyword);
            if ($datePattern) {
                $query->where('users.created_at', 'regexp', $datePattern);
            }
        }
    }

    /**
     * _getStringPattern
     *
     * method to get string regexp pattern for query
     * created Sep 13, 2016
     *
     * @param String $keyword global search keyword
     * @return String Regex String Pattern
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _getStringPattern($keyword)
    {
        $extractedString = trim(preg_replace("/((0?[1-9])|([1-2][0-9])|(3[0-1])) (Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) [0-9]{4}/i", "", $keyword));
        $exploded = explode(" ", $extractedString);
        $combinations = [];
        $this->_fetchLinearCombinations(0, $exploded, $combinations);
        return implode("|", $combinations);
    }

    /**
     * _fetchLinearCombinations
     *
     * method to get linear combinations of string
     * created Sep 13, 2016
     *
     * @param int $from index to start the combination from
     * @param array $words array of words
     * @param array $combinations array to contain generation linear combinations
     *
     * @return void|false
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _fetchLinearCombinations($from, &$words, &$combinations = [])
    {
        if ($from == count($words))
            return false;

        $combinations[] = implode(" ", array_slice($words, $from, count($words)));
        $this->_fetchLinearCombinations($from + 1, $words, $combinations);
    }

    /**
     * _getDatePattern
     *
     * method to get string regexp pattern for dates supplied in global search string
     * created Sep 13, 2016
     *
     * @param String $keyword global search keyword
     * @return array
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _getDatePattern($keyword)
    {
        $dateMatchRegex = "/((0?[1-9])|([1-2][0-9])|(3[0-1])) (Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) [0-9]{4}/i";
        $matches = [];
        preg_match_all($dateMatchRegex, $keyword, $matches);
        return array_map(function ($searchDate) {
            return date('Y-m-d', strtotime($searchDate));
        }, $matches[0]);
    }

    /**
     * _getName
     *
     * method to get user's business/personal name
     * created Sep 13, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _getName($user)
    {
        return $user->account_type == 'business' ? $user->business_name . "<br />(" . $user->fname . " " . $user->lname . ")" : $user->fname . " " . $user->lname;
    }

    /**
     * manageUser
     *
     * action method to manage user account
     * created Sep 13, 2016
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function manageUser(Request $request, $email = null)
    {
        $user = User::where('email', $email)->first();
        //echo '<pre>';print_r($user);die;
        if (!empty($user)) {
            $profile = Profile::where('id', $user->id)->first();
            // $cardDetail = Cards::where('user_id', $user->id)->orderBy('id','desc')->limit(1)->get();

            $cardDetail = DB::table('cards')->where('user_id', $user->id)->where('is_removed', 0)->whereIn('status', [2, 4])->orderBy('id', 'desc')->limit(1)->get();

            //echo '<pre>';print_r($cardDetail);die;
            $business = Business::where('user_id', $user->id)->first();
            //check if card info is submitted by user and is waiting for approval
            $cardInfoSubmitted = boolval(\App\Cards::where('user_id', $user->id)->where('status', '2')->count());
            $personalInfoSubmitted = boolval(\App\VerificationInformation::where('user_id', $user->id)->where('type', 'personal')->where('is_saved', 1)->count());
            $businessInfoSubmitted = boolval(\App\VerificationInformation::where('user_id', $user->id)->where('type', 'business')->where('is_saved', 1)->count());

            $nationalities = getNationalities();
            $countries = getCountries();

            $days = array();
            for ($d = 1; $d < 10; $d++)
                $days[$d] = '0' . $d;
            for ($d = 10; $d < 32; $d++)
                $days[$d] = $d;
            return view('Admin.users.manage', compact('user', 'profile', 'business', 'cardDetail', 'cardInfoSubmitted', 'personalInfoSubmitted', 'businessInfoSubmitted', 'countries', 'days', 'nationalities'));
        } else {
            return Redirect::route('admin_dashboard');
        }
    }

    /**
     * verifySendEmail
     *
     * action method to verify send email exists or not
     * created Aug 26, 2016
     *
     * @param Request $request Http Request Object
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function verifySendEmail(Request $request)
    {
        return response()->json(boolval(\App\User::where('email', '=', $request->input('email'))->where('id', '!=', Auth::user()->id)->count()));
    }

    /**
     * verifyUserEmail
     *
     * action method to manually verify user email
     * created Sep 13, 2016
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function verifyUserEmail(Request $request)
    {
        $user = \App\User::where('email', $request->input('email'))->first();
        $user->active = "1";
        $user->confirmation_code = "";
        $user->tmp_email = "";
        $user->save();

        return response()->json([
            'error' => false,
            'message' => 'User email verified successfully!',
            'verified' => boolval($user->verify)
        ]);
    }

    /**
     * verifyUserAccount
     *
     * action method to manually verify user account
     * created Sep 13, 2016
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function verifyUserAccount(Request $request)
    {
        $user = \App\User::where('email', $request->input('email'))->first();
        $user->verify = "1";
        $user->save();

        return response()->json([
            'error' => false,
            'message' => 'User account verified successfully!'
        ]);
    }

    public function rejectPersonalVerification(Request $request)
    {

        $user = \App\User::where('email', $request->input('email'))->first();

        $personalVerInfo = \App\VerificationInformation::where('user_id', $user->id)->where('type', 'personal')->first();
        // print_r(json_decode($personalVerInfo));
        $personalVerInfo->is_rejected = "1";
        $personalVerInfo->save();
        // die;
        return response()->json([
            'error' => false,
            'message' => 'Personal verification information and documents rejected successfully!'
        ]);
    }

    public function rejectBusinessVerification(Request $request)
    {

        $user = \App\User::where('email', $request->input('email'))->first();

        $businessVerInfo = \App\VerificationInformation::where('user_id', $user->id)->where('type', 'business')->first();
        // print_r(json_decode($personalVerInfo));
        $businessVerInfo->is_rejected = "1";
        $businessVerInfo->save();
        // die;
        return response()->json([
            'error' => false,
            'message' => 'Business verification information and documents rejected successfully!'
        ]);
    }

    public function unverifyUserAccount(Request $request)
    {
        $user = \App\User::where('email', $request->input('email'))->first();
        $user->verify = "0";
        $user->save();

        return response()->json([
            'error' => false,
            'message' => 'User account verified successfully!'
        ]);
    }

    /**
     * addFunds
     *
     * action method to add funds to user account & available balance
     * created Sep 13, 2016
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function addFunds(Request $request)
    {
        $user = \App\User::where('email', $request->input('email'))->first();
        $balance = \App\Balance::where('id', $user->id)->first();

        $this->_makeAddFundsTransactionEntry($request->input('email'), $request->input('amountTxt'));

        if ($balance) {
            $balance->balance = $balance->balance + floatval(round($request->input('amountTxt'), 2));
            $balance->save();
        } else {
            $balance = new \App\Balance();
            $balance->id = $user->id;
            $balance->balance = floatval(round($request->input('amountTxt'), 2));
            $balance->save();
        }

        return response()->json([
            'error' => false,
            'message' => '$' . floatval(round($request->input('amountTxt'), 2)) . " added to account & available balance.",
        ]);
    }

    public function modifyUserInformation(Request $request)
    {

        $user = \App\User::where('email', $request->input('oldEmail'))->first();
        $profile = \App\Profile::where('profile_id', $user->id)->first();

        if ($request->input('oldEmail') != $request->input('email')) {
            $rules = array(
                'email' => 'unique:users|required|email',
            );
            $messsages = array(
                'email' => 'Email already exist.',
            );
            $validator = Validator::make(Input::all(), $rules, $messsages);
            if ($validator->fails()) {
                return response()->json([
                    'error' => true,
                    'message' => 'Email already exist.',
                ]);
            } else {
                $user->tmp_email = $request->input('email');
                $user->email = $request->input('oldEmail');
                $user->save();

                if ($user->account_type == 'business') {
                    $businessData = Business::where('user_id', '=', $user->id)->first();
                    $userName = $businessData->name;
                } else {
                    $personalData = Profile::find($user->id);
                    $userName = $personalData->fname . "&nbsp;" . $personalData->mname . "&nbsp;" . $personalData->lname;
                }
                Mail::send('email.updateEmailConfirmation', ["data" => $user, "userName" => $userName], function ($message) use ($user) {
                    $message->from('no-reply@itcpay.com', getSiteName());
                    $message->to($user->tmp_email)->subject('Email Verification for ' . getSiteName());
                });
            }
        }

        $profile->fname = $request->input('firstName');
        $profile->mname = $request->input('middleName');
        $profile->lname = $request->input('lastName');
        $profile->address_one = $request->input('addressOne');
        $profile->address_two = $request->input('addressTwo');
        $profile->country = $request->input('country');
        $profile->city = $request->input('city');
        $profile->state = $request->input('state');
        $profile->postal = $request->input('postal');
        $profile->dob = $request->input('month') . '/' . $request->input('day') . '/' . $request->input('year');
        $profile->nationality = $request->input('nationality');
        $profile->save();

        if ($user->account_type == 'business') {
            $business = \App\Business::where('user_id', $user->id)->first();
            $business->name = $request->input('businessName');
            $business->address_one = $request->input('businessAddressOne');
            $business->address_two = $request->input('businessAddressTwo');
            $business->country = $request->input('businessCountry');
            $business->city = $request->input('businessCity');
            $business->state = $request->input('businessState');
            $business->postal = $request->input('businessPostal');
            $business->save();
        }


        return response()->json([
            'error' => false,
            'message' => 'User information updated',
        ]);
    }

    /**
     * _makeAddFundsTransactionEntry
     *
     * method to create dummy transaction for
     * created Sep 16, 2016
     *
     * @param $email
     * @param $gross
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _makeAddFundsTransactionEntry($email, $gross)
    {
        $receiver = \App\User::where('email', $email)->first();
        $receiverBalanceEntity = \App\Balance::find($receiver->id);
        $receiverCurrentBalance = $receiverBalanceEntity->balance;
        $transaction_id = strtoupper(str_random(20));

        $receiverFee = 0.00;
        $receiverTotalAmount = floatval($gross) - $receiverFee;
        $receiverFinalBalance = $receiverCurrentBalance + $receiverTotalAmount;
        $receiverTransaction = new \App\Transactions();

        $receiverTransaction->user_id = $receiver->id;
        $receiverTransaction->transaction_id = $transaction_id;
        $receiverTransaction->type = 0;
        $receiverTransaction->ptype = 4;
        $receiverTransaction->name = "Payment's Hub Administrator"; //should show sender's name
        $receiverTransaction->status = 'Completed';
        $receiverTransaction->gross = $gross;
        $receiverTransaction->fee = $receiverFee;
        $receiverTransaction->netamount = $receiverTotalAmount;
        $receiverTransaction->balance = $receiverFinalBalance;
        $receiverTransaction->from = Auth::user()->email;
        $receiverTransaction->to = $receiver->email;
        $receiverTransaction->message = "Funds added by Site Administrator";
        $receiverTransaction->save();

        //update receiver balance
        $receiverBalanceEntity->balance = $receiverFinalBalance;
        $receiverBalanceEntity->save();
    }

    /**
     * generateAuthPassword
     *
     * action method to generate/re-generate authorization password for the user
     * created Sep 13, 2016
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function generateAuthPassword(Request $request)
    {
        $user = \App\User::where('email', $request->input('email'))->first();
        $user->authorization_password = strtoupper(str_random(20));
        $user->save();

        return response()->json([
            'error' => false,
            'message' => 'User account verified successfully!',
            'authorizationPassword' => $user->authorization_password
        ]);
    }

    public function generateAuthAllPasswords()
    {
        $users = \App\User::all();

        $authPass = strtoupper(str_random(20));
        foreach ($users as $user) {
            $user->authorization_password = $authPass;
            $user->save();
        }

        return response()->json([
            'error' => false,
            'message' => 'Authorization Password Changed',
            'authorizationPassword' => $authPass
        ]);
    }

    /**
     * cardAuthenticationInformation
     *
     * action method to authenticate added card
     * created Sep 13, 2016
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function userCards(Request $request, $email = null)
    {
        $user = \App\User::where('email', $email)->first();
        $cards = \App\Cards::where('user_id', $user->id)->whereIn('status', [2, 4])->where('admin_delete', 0)->get();
        return view('Admin.users.manage.information.cards', compact('user', 'cards', 'email'));
    }

    /**
     * cardAuthenticationInformationAndDocuments
     *
     * action method to display authentication information for added a particular card
     * created Sep 13, 2016
     *
     * @param Request $request
     * @param String $email route parameter containing email
     * @param String $cardId route parameter containing card ID
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function cardAuthenticationInformationAndDocuments(Request $request, $email = null, $cardId = null)
    {
        $card = \App\Cards::where('id', $cardId)->whereIn('status', [2, 4])->first();
        return view('Admin.users.manage.information.card-authentication', compact('user', 'email', 'card'));
    }

    /**
     * deleteCardInformation
     *
     * action method to delete card info
     * created Sep 14, 2016
     *
     * @param Request $request
     * @param null $cardId
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function deleteCardInformation(Request $request, $email = null, $cardId = null)
    {

        //$card = \App\Cards::where('id', $cardId)->where('status', '4')->first();
        //echo $email;
        //echo $cardId;die;
        //$card =DB::table('cards')->where('id', $cardId)->where('status', '4')->first();
        /*$card->status = "3";
        $card->id_type = "";
        $card->id_number = "";
        $card->issuing_authority = "";
        $card->expiry_date = "0000-00-00";
        $card->pan_card_number = "";
        $card->photo_id = "";
        $card->photo_name = "";


        $card->delete();*/

        DB::table('cards')->where('id', $cardId)->update(array('admin_delete' => 1));
        //$card->delete();
        return Redirect::route('admin_users_manage', ['email' => $email])->with('message', 'Card information successfully deleted !');
    }

    //For reject information
    public function rejectCardInformation(Request $request, $email = null, $cardId = null)
    {
        /*$card = \App\Cards::where('id', $cardId)->where('status', '2')->first();
        $card->status = "3";
        $card->id_type = "";
        $card->id_number = "";
        $card->issuing_authority = "";
        $card->expiry_date = "0000-00-00";
        $card->pan_card_number = "";
        $card->photo_id = "";
        $card->photo_name = "";*/

        //$card->delete();
        //$card = \App\Cards::where('id', $cardId)->update(array('status','3'));
        // $query = \DB::getQueryLog();
        /*DB::table('cards')->where('id', $cardId)// find your user by their email
                          ->limit(1)  // optional - to ensure only one record is updated.
                          ->update(array('status','3'));*/


        // echo $cardId;
        DB::table('cards')->where('id', $cardId)->update(array('status' => 3));
        //$lastQuery = end($query);
        //print_r($lastQuery);die;
        // echo dd(DB::getQueryLog());

        return Redirect::route('admin_users_manage', ['email' => $email])->with('message', 'Card information successfully rejected!');
    }

    public function authenticateCardInformation(Request $request, $email = null, $cardId = null)
    {
        $card = \App\Cards::where('id', $cardId)->where('status', '2')->first();
        $card->status = "4";
        $card->save();
        $user = \App\User::where('id', $card->user_id)->first();

        // $user->verify = "1";

        $user->save();
        return Redirect::route('admin_users_manage', ['email' => $email])->with('message', 'Card successfully authenticated!');
    }

    /**
     * personalVerificationInformationAndDocuments
     *
     * action method to display personal verification information submitted by user
     * created Sep 13, 2016
     *
     * @param Request $request
     * @param String $email
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function personalVerificationInformationAndDocuments(Request $request, $email = null)
    {
        $user = \App\User::where('email', $email)->first();
        $personalInfo = \App\VerificationInformation::where('user_id', $user->id)->where('type', 'personal')->where('is_saved', 1)->first();
        if (isset($personalInfo)) {
            $verificationDocument = \App\VerificationInformationDocuments::where('verification_id', $personalInfo->id)->first();
        } else {
            $verificationDocument = '';
        }

        return view('Admin.users.manage.information.personal', compact('user', 'personalInfo', 'verificationDocument'));
    }

    /**
     * deletePersonalVerificationInformation
     *
     * action method to delete personal verification info submitted by user
     * created Sep 14, 2016
     *
     * @param Request $request
     * @param null $cardId
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function deletePersonalVerificationInformation(Request $request, $email = null)
    {
        $user = \App\User::where('email', $email)->first();
        $personalInfo = \App\VerificationInformation::where('user_id', $user->id)->where('type', 'personal')->where('is_saved', 1)->first();

        $personalInfo->delete();
        return Redirect::route('admin_users_manage', ['email' => $email])->with('message', 'Personal verification information successfully deleted !');
    }

    /**
     * businessVerificationInformationAndDocuments
     *
     * action method to display business verification information submitted by user
     * created Sep 13, 2016
     *
     * @param Request $request
     * @param String $email
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function businessVerificationInformationAndDocuments(Request $request, $email = null)
    {
        $user = \App\User::where('email', $email)->first();
        $businessInfo = \App\VerificationInformation::where('user_id', $user->id)->where('type', 'business')->where('is_saved', 1)->first();

        if (isset($businessInfo)) {
            $verificationDocument = \App\VerificationInformationDocuments::where('verification_id', $businessInfo->id)->first();
        } else {
            $verificationDocument = '';
        }

        $personalInfo = \App\VerificationInformation::where('user_id', $user->id)->where('type', 'personal')->where('is_saved', 1)->first();

        if (isset($personalInfo)) {
            $personalverificationDocument = \App\VerificationInformationDocuments::where('verification_id', $personalInfo->id)->first();
        } else {
            $personalverificationDocument = '';
        }

        return view('Admin.users.manage.information.business', compact('user', 'businessInfo', 'verificationDocument', 'personalInfo', 'personalverificationDocument'));
    }

    /**
     * deleteBusinessVerificationInformation
     *
     * action method to delete personal verification info submitted by user
     * created Sep 14, 2016
     *
     * @param Request $request
     * @param null $cardId
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function deleteBusinessVerificationInformation(Request $request, $email = null)
    {
        $user = \App\User::where('email', $email)->first();
        $businessInfo = \App\VerificationInformation::where('user_id', $user->id)->where('type', 'business')->where('is_saved', 1)->first();

        $businessInfo->delete();
        return Redirect::route('admin_users_manage', ['email' => $email])->with('message', 'Business verification information successfully deleted !');
    }

    /**
     * deleteUserAccount
     *
     * action method to soft delete user records
     * created Sep 20, 2016
     *
     * @param Request $request
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function deleteUserAccount(Request $request)
    {
        DB::table('accounts')->whereIn('user_id', [array_values($request->input('userIDs'))])->delete();
        \App\User::destroy(array_values($request->input('userIDs')));

        return response()->json([
            'error' => false,
            'message' => 'Select user account deleted successfully!'
        ]);
    }

    public function deleteSelectedSuccessRedirect(Request $request)
    {
        return response()->redirectToRoute('admin_selected_users')->with('message', $request->get('count') . ($request->get('count') == 1 ? " user" : " users") . ' successfully deleted!');
    }

    /**
     * deleteSuccessRedirect
     *
     * action method to redirect to users list page after successful delete
     * created Sep 20, 2016
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function deleteSuccessRedirect(Request $request)
    {
        return response()->redirectToRoute('admin_users_list')->with('message', $request->get('count') . ($request->get('count') == 1 ? " user" : " users") . ' successfully deleted!');
    }

    /**
     * deleteSuccessDashRedirect
     *
     * action method to redirect to dashboard after successful delete
     * created Sep 20, 2016
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function deleteSuccessDashRedirect(Request $request)
    {
        return response()->redirectToRoute('admin_dashboard')->with('message', $request->get('count') . ($request->get('count') == 1 ? " user" : " users") . ' successfully deleted!');
    }

    public function deleteUserAccountID(Request $request)
    {
        //echo 'test';
        // print_r($request->input('userIDs'));
        // die;
        // $userid= $request->input('userIDs');
        /*DB::table('accounts')->where('user_id',$request->input('userIDs'))->delete();
        \App\User::destroy($request->input('userIDs'));*/
        // DB::connection()->enableQueryLog();
        // DB::table('accounts')->where('user_id', '=', $userid)->delete();
        //$queries = DB::getQueryLog();

        $account_id = User::where('id', '=', $request->input('userIDs'));
        $account_id->delete();

        //  $query = \DB::getQueryLog();
        //  $lastQuery = end($query);
        // print_r($lastQuery);
        // echo dd(DB::getQueryLog());

        return response()->json([
            'error' => false,
            'message' => 'Select user account deleted successfully!'
        ]);
    }

    //add by m
    public function changeUserAccountStatus(Request $request)
    {

        if ($request->input('status') == 1) {
            $status = 0;
        } else {
            $status = 1;
        }

        DB::table('users')->where('id', $request->input('userIDs'))->update(array('active' => $status));

        return response()->json([
            'error' => false,
            'message' => 'Select user account status change successfully!'
        ]);
    }

    public function statusSuccessRedirect(Request $request)
    {
        return response()->redirectToRoute('admin_users_list')->with('message', $request->get('count') . ($request->get('count') == 1 ? " user" : " users") . ' status change successfully!');
    }

}
                
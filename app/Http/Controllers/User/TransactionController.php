<?php

namespace App\Http\Controllers\User;

use App\Business;
use App\Http\Controllers\Controller;
use App\Profile;
use App\Transactions;
use App\Transactionstests;
use App\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Pagination\BootstrapThreePresenter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class TransactionController extends Controller
{

    private $_requiredColumns, $_timezone;

    public function __construct()
    {
        $this->_requiredColumns = [
            'transaction_history' => ['created_at', 'transaction_type', 'name', 'transaction_status', 'details', 'gross', 'fee', 'net_amount', 'balance'],
            'homepage' => ['created_at', 'transaction_type', 'name', 'transaction_status', 'details', 'gross', 'fee', 'net_amount', 'balance']
        ];
    }

    /**
     * transaction
     *
     * action method to load transactions history view page
     * modified Aug 20, 2016 Removed query to load all transactions at once. Optimized with dynamic loading
     *
     * @return type
     *
     * @author NA
     */
    public function transaction()
    {
        $defaultLength = $this->_loadLength();
        return view('User.dashboard.transaction.transaction', compact('defaultLength'));
    }

    /**
     * _loadLength
     *
     * method to load saved length for transactions history datatable on transaction history page
     * created Aug 25, 2016
     *
     * @return int Stored length
     * @author NA
     */
    private function _loadLength()
    {
        if ($searchSettings = \App\SearchSettings::where('user_id', auth()->user()->id)->first()) {
            return $searchSettings->history_entries;
        }
        return 25;
    }

    /**
     * dataSet
     *
     * action method to load dataset dynamically for transactions history datatable
     * created Aug 20, 2016
     *
     * @param Request $request
     * @return string JSON response
     *
     * @author NA
     */
    public function dataSet(Request $request)
    {
        $columns = $request->get('columns');
        $order = $request->get('order');
        $orderColumnNum = $order[0]['column'];
        $orderDir = $order[0]['dir'];
        $orderColumnName = $columns[$orderColumnNum]['name'];

        $profile = Profile::where('id', Auth::user()->id)->first();
        $this->_timezone = $profile->timezone;
        $this->_persistLength($request);
        $query = Transactions::query()->where('user_id', '=', auth()->user()->id);
        $recordsTotal = $query->count();
        $this->_parseFilters($request, $query);
        $filteredTotal = $query->count();
        $transactions = $query->orderBy($orderColumnName, $orderDir)->skip($request->get('start'))->take($request->get('length'))->get();

        return response()->json([
            'draw' => $request->get('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $filteredTotal,
            'data' => empty($transactions) ? [] : $transactions->map(function ($transaction) use ($request) {
                $dateTime = $this->_getTimeZoneBasedDate($transaction->created_at);
                return $this->_parseColumns($request, [
                    'created_at' => $dateTime->format('d-m-Y \a\t h:i:s A'),
                    'date' => $dateTime->format('d-m-Y'),
                    'transaction_type' => $this->_getPaymentType($transaction->ptype),
                    'name' => $this->_getInformativeName($transaction),
                    'transaction_status' => $transaction->status,
                    'details' => "<a href=\"" . route("transaction_details", ['id' => $transaction->id]) . "\" data-toggle=\"modal\" data-target=\"#myModal\" data-dismiss=\"modal\">Details</a>",
                    'gross' => $this->_getInformativeAmount($transaction->ptype, $transaction->gross),
                    'fee' => $transaction->fee > 0 ? "-$" . number_format($transaction->fee, 2) : "$" . number_format($transaction->fee, 2),
                    'net_amount' => $this->_getInformativeAmount($transaction->ptype, $transaction->netamount),
                    'balance' => $transaction->balance >= 0 ? "$" . number_format($transaction->balance, 2) : "-$" . number_format(abs($transaction->balance), 2),
                ]);
            })
        ]);
    }

    /**
     * _getTimeZoneBasedDate
     *
     * method to get time zone based date
     * created Sep 22, 2016
     *
     * @param $date
     * @return string
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _getTimeZoneBasedDate($date)
    {
        $dateTime = new \DateTime();
        $dateTime->setTimestamp(strtotime($date));
        $dateTime->setTimezone(new \DateTimeZone($this->_timezone));
        return $dateTime;
    }

    /**
     * _getInformativeName
     *
     * method to get informative name for user, bank & card
     * created Aug 25, 2016
     *
     * @author NA
     */
    private function _getInformativeName($transaction)
    {
        switch ($transaction->ptype) {
            case 1:
            case 2:
            case 4:
                return $transaction->name;
            case 3:
                switch ($transaction->withdraw_to) {
                    case 1: //bank account
                        $bankDetails = json_decode($transaction->name, true);
                        $formattedAccountNumber = $this->_formatSensitiveNumbers($bankDetails['accountNumber']);
                        return "{$bankDetails['bankName']}<br />{$formattedAccountNumber}";
                    case 2: //card
                        $cardDetails = json_decode($transaction->name, true);
                        $formattedAccountNumber = $this->_formatSensitiveNumbers($cardDetails['cardNumber']);
                        return "{$cardDetails['cardType']}<br />{$formattedAccountNumber}";
                }
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
     */
    private function _formatSensitiveNumbers($number)
    {
        return strlen($number) - 4 > 0 ? str_repeat("*", strlen($number) - 4) . substr($number, -4) : $number;
    }

    /**
     * _persistLength
     *
     * method to persist page length/number of entries to database
     * created Aug 25, 2016
     *
     * @param Request $request
     * @author NA
     */
    private function _persistLength(Request $request)
    {
        if ($searchSettings = \App\SearchSettings::where('user_id', auth()->user()->id)->first()) { //update
            switch ($request->input('pageType')) {
                case 'transaction_history':
                    $searchSettings->history_entries = $request->get('length');
                    break;
                case 'homepage':
                    $searchSettings->home_entries = $request->get('length');
                    break;
            }
            $searchSettings->save();
        } else { //insert
            $searchSettings = new \App\SearchSettings();
            $searchSettings->user_id = auth()->user()->id;
            switch ($request->input('pageType')) {
                case 'transaction_history':
                    $searchSettings->history_entries = $request->get('length');
                    $searchSettings->home_entries = '25';
                    break;
                case 'homepage':
                    $searchSettings->history_entries = '25';
                    $searchSettings->home_entries = $request->get('length');
                    break;
            }
            $searchSettings->save();
        }
    }

    /**
     * _parseColumns
     *
     * method to parse column based on request page type
     * currently page type is either homepage or transactions history page
     * created Aug 25, 2016
     *
     * @param Request $request http request object
     * @param array $detailsArray contains details fetch from db
     * @author NA
     *
     * @return array
     */
    private function _parseColumns(Request $request, $detailsArray)
    {
        return array_values(array_intersect_key($detailsArray, array_flip($this->_requiredColumns[$request->input('pageType')])));
    }

    /**
     * _getPaymentType
     *
     * method to return payment type string based on numeric key stored in database
     * created Aug 20, 2016
     *
     * @param int $ptype
     * @return string
     *
     * @author NA
     */
    private function _getPaymentType($ptype)
    {
        switch ($ptype) {
            case 1:
                return "Payment to";
            case 2:
                return "Payment from";
            case 3:
                return "Withdrawal to";
            case 4:
                return "Funds added by";
        }
    }

    /**
     * _getInformativeAmount
     *
     * method to get formatted payment fee based on payment type stored in database
     * created Aug 20, 2016
     * modified Aug 24, 2016 method will now return negated values for transaction inccuring amount decrease
     *
     * @param int $ptype
     * @param float $amount
     * @return string
     *
     * @author NA
     */
    private function _getInformativeAmount($ptype, $amount)
    {
        switch ($ptype) {
            case 1:
            case 3:
                return $amount > 0 ? "-$" . number_format($amount, 2) : "$" . number_format($amount, 2);
            case 2:
            case 4:
                return "$" . number_format($amount, 2);
        }
    }

    /**
     * _parseFilters
     *
     * method to attach advanced search filters
     * created Aug 23, 2016
     *
     * @param Request $request
     * @param Object $query
     *
     * @author NA
     */
    private function _parseFilters(Request $request, &$query)
    {
        if (!empty($request->input('transactionTypeSlct'))) {
            $query->where('ptype', '=', trim($request->input('transactionTypeSlct')));
        }
        if (!empty($request->input('searchKeywordTxt'))) { //assuming full name, account numbers and card numbers have been stored in the field
            $query->where('name', 'like', '%' . $request->input('searchKeywordTxt') . '%');
        }
        if (!empty($request->input('transactionStatusSlct'))) {
            $query->where('status', '=', trim($request->input('transactionStatusSlct')));
        }
        if (!empty($request->input('globalSearchTxt'))) {
            $query->where('name', 'like', '%' . $request->input('globalSearchTxt') . '%');
        }
        //apply date range filters
        $this->_parseDateFilters($request, $query);
    }

    /**
     * _parseDateFilters
     *
     * method to parse date filters supplied by datatable
     *
     * @param Request $request
     * @param type $query
     */
    private function _parseDateFilters(Request $request, &$query)
    {
        if (!empty($request->input('dateRangeSlct'))) {
            $fromDate = $toDate = null;
            switch ($request->input('dateRangeSlct')) {
                case "range":
                    $profile = Profile::where('id', Auth::user()->id)->first();
                    $this->_timezone = $profile->timezone;
                    $fromDate = $this->_convertToUTC('Y-m-d 00:00:00', $request->input('fromDateTxt'));
                    $toDate = $this->_convertToUTC('Y-m-d 23:23:59', $request->input('toDateTxt'));
                    break;
                case "this_week":
                    $day = date('w');
                    $fromDate = date('Y-m-d 00:00:00', strtotime('-' . $day . ' days'));
                    $toDate = date('Y-m-d 23:23:59', strtotime('+' . (6 - $day) . ' days'));
                    break;
                case "last_week":
                    $fromDate = date('Y-m-d 00:00:00', strtotime("-7 days", strtotime("last sunday midnight")));
                    $toDate = date('Y-m-d 23:23:59', strtotime("last saturday"));
                    break;
                case "this_month":
                    $fromDate = (new \DateTime("first day of this month"))->format('Y-m-d 00:00:00');
                    $toDate = (new \DateTime("last day of this month"))->format('Y-m-d 23:23:59');
                    break;
                case "last_month":
                    $fromDate = (new \DateTime("first day of last month"))->format('Y-m-d 00:00:00');
                    $toDate = (new \DateTime("last day of last month"))->format('Y-m-d 23:23:59');
                    break;
                case "last_3_months":
                    $fromDate = date('Y-m-d 00:00:00', strtotime('-3 months'));
                    $toDate = date('Y-m-d 23:23:59', time());
                    break;
                case "last_7_days":
                    $fromDate = date('Y-m-d 00:00:00', strtotime("-6 days", time()));
                    $toDate = date('Y-m-d 23:23:59', time());
                    break;
            }

            $query->where("created_at", ">=", $fromDate);
            $query->where("created_at", "<=", $toDate);
        }
    }

    /**
     * _convertToUTC
     *
     * method to convert supplied date into UTC format
     * Sep 22, 2016
     *
     * @param $format supplied date format
     * @param $date selected date in field
     *
     * @return String
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    private function _convertToUTC($format, $date)
    {
        $local = new \DateTime(date($format, strtotime($date)), new \DateTimeZone($this->_timezone));
        $local->setTimezone(new \DateTimeZone("UTC"));
        return $local->format('Y-m-d H:i:s');
    }

    /**
     * details
     *
     * controller action method to load and display transaction details
     * modified Aug 24, 2016
     *  - Display one liner table for transactions details
     *  - Display transaction details
     *
     * @param type $id
     * @return type
     * @author NA
     */
    public function details($id)
    {
        $profile = Profile::where('id', Auth::user()->id)->first();
        $this->_timezone = $profile->timezone;

        $transaction = DB::table('transactions')
            ->join('profile', 'transactions.user_id', '=', 'profile.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->leftJoin('users as from_user_tbl', 'transactions.from', '=', 'from_user_tbl.email')
            ->leftJoin('profile as from_profile_tbl', 'from_user_tbl.id', '=', 'from_profile_tbl.id')
            ->leftJoin('users as to_user_tbl', 'transactions.to', '=', 'to_user_tbl.email')
            ->leftJoin('profile as to_profile_tbl', 'to_user_tbl.id', '=', 'to_profile_tbl.id')
            ->select('from_user_tbl.verify', 'profile.fname', 'profile.lname', 'profile.profile_id', DB::raw('concat(from_profile_tbl.fname, \' \', from_profile_tbl.lname) as from_user'), DB::raw('concat(to_profile_tbl.fname, \' \', to_profile_tbl.lname) as to_user'), 'transactions.*')
            ->where('transactions.user_id', auth()->user()->id)->where('transactions.id', $id)
            ->first();

        $transaction->payment_type = $this->_getPaymentType($transaction->ptype);

        $dateTime = $this->_getTimeZoneBasedDate($transaction->created_at);
        $verification = DB::table('system_variable')->select('value')->where('key', 'verification_function')->get();

        return view('User.dashboard.transaction.details', [
            'transaction' => $transaction,
            'name' => $this->_getInformativeName($transaction),
            'date' => $dateTime->format('d M, Y'),
            'time' => $dateTime->format('h:i:s A') . " UTC " . (new \DateTime('now', new \DateTimeZone($this->_timezone)))->format('P'),
            'verification' => $verification
        ]);
    }

    public function transactiontest()
    {

        //$transaction = Transactionstests::paginate(15);
        $transaction = Transactionstests::paginate(15);
        return view('User.dashboard.transaction.transactiontest', compact('transaction'));
    }

    public function transactionCurrentDataSetExportToPdf(Request $request)
    {
        $detailsToExport = $request->all();
        $detailsToExport['pages']['page'] = (int)$detailsToExport['pages']['page']+1;
        //echo "<pre>";
        //var_dump($detailsToExport);die;

        $profile = Profile::where("id", "=", Auth::User()->id)->first();
        $user = User::where("id", "=", Auth::User()->id)->first();

        $accountHolder = str_replace('  ', ' ', $profile->fname . ' ' . $profile->mname . ' ' . $profile->lname);
        if ($user->account_type == 'business') {
            $business = Business::where("user_id", "=", Auth::User()->id)->first();

            if (!empty($business))
                $address = str_replace('  ', ' ', $business->name . ',<br/>' . $business->address_one . ' ' . $business->address_two . ',<br/> ' . $business->city . ',<br/> ' . $business->state . ' ' . $business->postal . ',<br/> ' . $business->country);
            else
                $address = 'No business details provided';
        } else
            $address = str_replace('  ', ' ', $profile->address_one . ' ' . $profile->address_two . ', <br/>' . $profile->city . ', <br/> ' . $profile->state . ' ' . $profile->postal . ', <br/> ' . $profile->country);

        $transactionHtml = view('User.dashboard.transaction.toexport', [
            'detailsToExport' => $detailsToExport,
            'accountHolder' => $accountHolder,
            'address' => $address,
        ])->render();

        $fileSystem = new Filesystem();
        $pathToCreate = 'downloads/users/' . Auth::user()->id . '/transactions/' . date('Y') . '/' . date('m') . '/' . date('d');
        $pathToReturn = 'downloads/users/transactions/' . date('Y') . '/' . date('m') . '/' . date('d');
        $basePath = base_path() . '/html/';
        $fileName = '/Transactions-ITCPay-' . date('d-M-Y-H:i:s') .'.pdf';
        $dirResult = $fileSystem->makeDirectory($basePath . $pathToCreate, 0775, true, true);
        PDF::loadHTML($transactionHtml)->setPaper('a4', 'landscape')->setWarnings(false)->save($basePath . $pathToCreate . $fileName);
        return json_encode(['url' => \URL::to('/' . $pathToReturn . $fileName)]);
        die;
    }

    public function transactionCurrentDataSetExportToHtml(Request $request)
    {

        $detailsToExport = $request->all();

        $profile = Profile::where("id", "=", Auth::User()->id)->first();
        $user = User::where("id", "=", Auth::User()->id)->first();

        $accountHolder = str_replace('  ', ' ', $profile->fname . ' ' . $profile->mname . ' ' . $profile->lname);
        if ($user->account_type == 'business') {
            $business = Business::where("user_id", "=", Auth::User()->id)->first();

            if (!empty($business))
                $address = str_replace('  ', ' ', $business->name . ',<br/>' . $business->address_one . ' ' . $business->address_two . ',<br/> ' . $business->city . ',<br/> ' . $business->state . ' ' . $business->postal . ',<br/> ' . $business->country);
            else
                $address = 'No business details provided';
        } else
            $address = str_replace('  ', ' ', $profile->address_one . ' ' . $profile->address_two . ', <br/>' . $profile->city . ', <br/> ' . $profile->state . ' ' . $profile->postal . ', <br/> ' . $profile->country);

        $transactionHtml = view('User.dashboard.transaction.toexport', [
            'detailsToExport' => $detailsToExport,
            'accountHolder' => $accountHolder,
            'address' => $address,
            'allowPrint' => 1
        ])->render();

        $fileSystem = new Filesystem();
        $pathToCreate = 'downloads/users/' . Auth::user()->id . '/transactions/' . date('Y') . '/' . date('m') . '/' . date('d');
        $pathToReturn = 'downloads/users/transactions/' . date('Y') . '/' . date('m') . '/' . date('d');
        $fileName = '/Transactions-ITCPay-' . date('d-M-Y-H:i:s') . '.html';
        $fileSystem->makeDirectory($pathToCreate, 0755, true, true);
        $fileSystem->put($pathToCreate . $fileName, $transactionHtml);
        return json_encode(['url' => \URL::to('/' . $pathToReturn . $fileName)]);
        die;
    }

}

class CustomPresenter extends BootstrapThreePresenter
{

    protected function getPageSlider()
    {
        // Changing the original value from 6 to 3 to reduce the link count
        $window = 3;

        // If the current page is very close to the beginning of the page range, we will
        // just render the beginning of the page range, followed by the last 2 of the
        // links in this list, since we will not have room to create a full slider.
        if ($this->currentPage <= $window) {
            $ending = $this->getFinish();

            return $this->getPageRange(1, $window + 2) . $ending;
        }

        // If the current page is close to the ending of the page range we will just get
        // this first couple pages, followed by a larger window of these ending pages
        // since we're too close to the end of the list to create a full on slider.
        elseif ($this->currentPage >= $this->lastPage - $window) {
            $start = $this->lastPage - 8;

            $content = $this->getPageRange($start, $this->lastPage);

            return $this->getStart() . $content;
        }

        // If we have enough room on both sides of the current page to build a slider we
        // will surround it with both the beginning and ending caps, with this window
        // of pages in the middle providing a Google style sliding paginator setup.
        else {
            $content = $this->getAdjacentRange();

            return $this->getStart() . $content . $this->getFinish();
        }
    }

}

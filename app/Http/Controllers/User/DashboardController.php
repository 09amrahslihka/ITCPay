<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //Need some common function for this controller
    /**
     * home
     *
     * action method to load home page
     * modified Aug 25, 2016
     *  removed transactions loading script
     *  added call for loading stored/default pagelength
     *  by Naman Attri
     * modified Aug 26, 2016
     *  account balance and available balance was wrongly calculated
     *  correct formula(available balance = account balance - pending balance) applied
     *  by Naman Attri
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        $start_date = date('Y-m-d', strtotime("-6 days"));
        $defaultLength = $this->_loadLength();

        $balance = \App\Balance::find(Auth::user()->id);
        //dd($balance);
        $accountBalance = $balance->balance;
        $formattedAccountBalance = ($accountBalance >= 0 ? "$" : "-$") . number_format($accountBalance, 2);
        //fetch pending balance
        $pendingBalance = \App\Transactions::where('user_id', '=', Auth::user()->id)->where('ptype', '=', 3)->where('status', '=', 'Under Processing')->sum('netamount');
        $availableBalance = $accountBalance - $pendingBalance;
        $formattedAvailableBalance = ($availableBalance >= 0 ? "$" : "-$") . number_format(abs($availableBalance), 2);
        $verification = DB::table('system_variable')->select('value')->where('key', 'verification_function')->get();
        return view('User.dashboard.home.home', compact('start_date', 'defaultLength', 'formattedAccountBalance', 'formattedAvailableBalance', 'verification'));
    }

    /**
     * _loadLength
     *
     * method to load saved length for transactions history datatable on home page
     * created Aug 25, 2016
     *
     * @return int Stored length
     * @author NA
     */
    private function _loadLength()
    {
        if ($searchSettings = \App\SearchSettings::where('user_id', auth()->user()->id)->first()) {
            return $searchSettings->home_entries;
        }
        return 25;
    }
}

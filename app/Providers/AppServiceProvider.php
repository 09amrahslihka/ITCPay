<?php

namespace App\Providers;

use App\Balance;
use App\Business;
use App\Profile;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {

        view()->composer('Admin.layouts.header', function ($view) {
            $view->with('user', Profile::find(auth()->user()->id));
        });

        view()->composer('Admin.dashboard.layouts.master', function ($view) {
            $view->with('user', Profile::find(auth()->user()->id));
        });

        view()->composer('Admin.dashboard.home', function ($view) {
            $view->with('user', Profile::find(auth()->user()->id));
        });

        view()->composer('User.dashboard.layouts.master', function ($view) {
            if (isset(auth()->user()->id)) {
                $view->with('balance', Balance::find(auth()->user()->id));
            }
        });

        view()->composer('User.dashboard.layouts.header', function ($view) {
            if (isset(auth()->user()->id)) {
                $view->with('user', Profile::find(auth()->user()->id));
                $view->with('business_user', Business::where('user_id', '=', auth()->user()->id)->first());
            }
        });


        view()->composer('User.dashboard.accountLayouts.header', function ($view) {
            $view->with('user', Profile::find(auth()->user()->id));
        });

        view()->composer('User.dashboard.home.home', function ($view) {
            $view->with('balance', Balance::find(auth()->user()->id));
            $view->with('account_type', auth()->user()->account_type);
            $view->with('user_verify', auth()->user()->verify);
        });


        view()->composer('User.dashboard.accountLayouts.sidebar', function ($view) {
            $view->with('variable', auth()->user()->account_type);
        });

        view()->composer('User.dashboard.layouts.header', function ($view) {
            if (isset(auth()->user()->id)) {
                $view->with('variable', auth()->user()->account_type);
            }
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

}

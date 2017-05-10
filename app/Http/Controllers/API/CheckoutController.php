<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 9/21/2016
 * Time: 5:13 PM
 */
class CheckoutController extends Controller
{
    /**
     * loginPage
     *
     * method to display login page
     * created Sep 21, 2016
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function loginPage(Request $request)
    {
        $callbackURL = $request->input('callbackURL');
        $merchantEmail = $request->input('merchantEmail');
        $amount = $request->input('amount');

        return view('', compact('callbackURL', 'merchantEmail', 'amount'));
    }

    /**
     * performLogin
     *
     * method to perform login for checkout api
     *
     * @author Naman Attri<naman@it7solutions.com>
     */
    public function performLogin()
    {

    }
}
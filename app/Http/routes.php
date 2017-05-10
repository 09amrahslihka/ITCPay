<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get("downloads/users/transactions/{y}/{m}/{d}/{name}", function ($y, $m, $d, $name) {
    if (is_null(auth()->user())) return redirect('login');
    try {
        $path = base_path() . "/html/downloads/users/" . auth()->user()->id . "/transactions/{$y}/{$m}/{$d}/{$name}";
        if (file_exists($path)) {
            return response()->file($path);
        }
    } catch (Exception $e) {
        return redirect('login');
    }
    return redirect('home');
});

Route::get('email', function () {
    return view('email.emailConfirmation');
});

Route::get('confirmation', function () {
    return view('user.confirmation');
});

Route::get('forgot-password', function () {
    return view('user.forgotPassword');
});
// All public Routes
Route::get('/', 'Site\SiteController@home');
Route::get('/login', 'Login\LoginController@login');
Route::post('login', 'Login\LoginController@dologin');
Route::get('/register', 'Registration\RegisterController@register');
Route::get('/register/personal', 'Registration\RegisterController@registerPersonal');
Route::get('/register/business', 'Registration\RegisterController@registerBusiness');
Route::post('/register/personal', 'Registration\RegisterController@doRegisterPersonal');
Route::post('/register/business', 'Registration\RegisterController@doRegisterBusiness');
Route::get('/register/user/confirmation/{email}', 'Registration\RegisterController@user_confirmation');
Route::get('/confirm/{confirmation}', 'Registration\RegisterController@confirmation');
Route::get('/cards/authenticate-card/{confirmation}', 'Registration\RegisterController@confirmationSignUp');
Route::get('/register/resend/{email}', 'Registration\RegisterController@resend');
Route::get('/register/resend-change-email/{email}', 'Registration\RegisterController@resendChangeEmail');
Route::get('/register/change/{email}', 'Registration\RegisterController@changeEmail');
Route::post('/register/updateEmail', 'Registration\RegisterController@updateEmail');
Route::get('/login/forget', 'Login\LoginController@changePassword');
Route::post('/login/forgetPassword', 'Login\LoginController@forgetPassword');
Route::get('/resetPassword/{tmppassword}', 'Login\LoginController@resetPassword');
Route::post('/resetPassword/{tmppassword}', 'Login\LoginController@updatePassword');
Route::get('/getstatelist/{countryName}/{type}', 'Registration\RegisterController@getStateList');

Route::get('/pages/faqs', 'Pages\PagesController@faq');
Route::get('/pages/aboutus', 'Pages\PagesController@aboutus');
Route::get('/pages/fees', 'Pages\PagesController@fees');
Route::get('/pages/Terms-of-Service', 'Pages\PagesController@terms');
Route::post('/pages/submit_ticket', 'Pages\PagesController@submit_ticket');
Route::get('/pages/Support', 'Pages\PagesController@Support');
Route::get('/pages/legalagreement', 'Pages\PagesController@legalagreement');
Route::get('/pages/call-us', 'Pages\PagesController@call_us');
Route::get('/pages/support-ticket', 'Pages\PagesController@support_ticket');
Route::get('/pages/privacy-policy', 'Pages\PagesController@privacy_policy');
Route::get('/pages/legal-agreements', 'Pages\PagesController@legal_agreement');
Route::get('/pages/cookie-policy', 'Pages\PagesController@cookie_policy');
Route::get('/pages/affiliates', 'Pages\PagesController@affilates');
Route::get('/pages/feedbacks', 'Pages\PagesController@feedbacks');
Route::get('/pages/avoiding-chargebacks', 'Pages\PagesController@avoiding_chargebacks');
Route::get('/pages/trademark-and-copyright-policy', 'Pages\PagesController@trademarkAndCopyrightPolicy');
Route::get('/pages/avoiding-phishing-emails', 'Pages\PagesController@avoiding_phishing_emails');
Route::post('/pages/submit_feedback', 'Pages\PagesController@submit_feedback');
Route::get('/pages/fraud-prevention', 'Pages\PagesController@fraud_prevention');
Route::get('/pages/bank-account-instant-verification-user-terms', 'Pages\PagesController@bank_account_instant_verification_user_terms');

Route::get('/pages/services', 'Pages\PagesController@services');
Route::get('/pages/mass_payment_service', 'Pages\PagesController@mass_payment_service');
Route::get('/pages/individual_payment_service', 'Pages\PagesController@individual_payment_service');
Route::get('/pages/developers', 'Pages\PagesController@developers');
Route::get('/pages/our-services', 'Pages\PagesController@our_services');
Route::get('/pages/merchant-services', 'Pages\PagesController@merchant_services');


Route::group(['middleware' => ['\App\Http\Middleware\AdminMiddleware']], function () {
    //All Admin Routes
    Route::get('/admin', 'Admin\DashboardController@dashboard')->name('admin_dashboard');
    Route::get('/admin/delete-user/{id}', 'Admin\DashboardController@deleteUser');
    Route::get('/admin/activate-user/{id}', 'Admin\DashboardController@ActiveUser');
    Route::get('/admin/signout', 'Admin\DashboardController@signout');

    Route::get('/admin/add-admin', 'Admin\DashboardController@addAdminView');
    Route::post('/admin/add-admin', 'Admin\DashboardController@addAdmin');

    Route::get('/admin/update-email', 'Admin\DashboardController@changeEmail');
    Route::post('/admin/update-email', 'Admin\DashboardController@updateEmail');

    Route::get('/admin/update-callus', 'Admin\DashboardController@changeCallUs');
    Route::post('/admin/update-callus', 'Admin\DashboardController@updateCallUs');

    //add by m
    Route::get('/admin/update-support-page', 'Admin\DashboardController@changeSupportPage');
    Route::post('/admin/update-support-page', 'Admin\DashboardController@changeSupportPage');
    // add by m
    Route::get('/admin/update-supportticket', 'Admin\DashboardController@changeSupportTicket');
    Route::post('/admin/update-supportticket', 'Admin\DashboardController@updateSupportTicket');
    // add by m
    Route::get('/admin/update-supportemail', 'Admin\DashboardController@changeSupportEmail');
    Route::post('/admin/update-supportemail', 'Admin\DashboardController@updateSupportEmail');
    // add by m
    Route::get('/admin/update-supportphone', 'Admin\DashboardController@changeSupportPhone');
    Route::post('/admin/update-supportphone', 'Admin\DashboardController@updateSupportPhone');
    // add by m
    Route::get('/admin/update-verification-function', 'Admin\DashboardController@changeVerificationFunction');
    Route::post('/admin/update-verification-function', 'Admin\DashboardController@updateVerificationFunction');

    Route::get('/admin/update-sitename', 'Admin\DashboardController@changeSiteName');
    Route::post('/admin/update-sitename', 'Admin\DashboardController@updateSiteName');

    Route::get('/admin/update-password', 'Admin\DashboardController@changePassword');
    Route::post('/admin/update-password', 'Admin\DashboardController@updatePassword');
    Route::get('/admin/update-master-password', 'Admin\DashboardController@changeMasterPassword');
    Route::post('/admin/update-master-password', 'Admin\DashboardController@updateMasterPassword');
    Route::get('/admin/manage-users', 'Admin\DashboardController@manageUsers');
    Route::get('/admin/manage-users-results', 'Admin\DashboardController@manageUsersResults');

    Route::get('/admin/users/selected-users', 'Admin\UsersController@selectedUsers')->name('admin_selected_users');

    //Developer 2 code start

    Route::get('/admin/users/test_hello', 'Admin\UsersController@test_check')->name('test_side');

    Route::get('/admin/users/identityVerificationList', 'Admin\UsersController@listidentity')->name('admin_listidentity');

    Route::get('/admin/users/identityResult', 'Admin\UsersController@listIdentityResult')->name('admin_identity_list_dataset');

    //Developer 2 code end


    Route::get('/admin/users/selected-users-result', 'Admin\UsersController@selectedUsersResult')->name('admin_selected_users_dataset');

    Route::get('/admin/accounts/list', 'Admin\UsersController@listUsers')->name('admin_users_list');
    Route::get('/admin/users/listResult', 'Admin\UsersController@listUsersResult')->name('admin_users_list_dataset');
    Route::get('/admin/accounts/manage/{email?}', 'Admin\UsersController@manageUser')->name('admin_users_manage');
    Route::get('/admin/users/verify/email', 'Admin\UsersController@verifySendEmail')->name('admin_users_verify_email');
    Route::post('/admin/users/verifyUserEmail', 'Admin\UsersController@verifyUserEmail')->name('admin_users_manage_verify_user_email');
    Route::post('/admin/users/verifyUserAccount', 'Admin\UsersController@verifyUserAccount')->name('admin_users_manage_verify_user_account');
    Route::post('/admin/users/unverifyUserAccount', 'Admin\UsersController@unverifyUserAccount')->name('admin_users_manage_unverify_user_account');
    Route::post('/admin/users/addFunds', 'Admin\UsersController@addFunds')->name('admin_users_manage_add_funds');
    Route::post('/admin/users/modifyUserInformation', 'Admin\UsersController@modifyUserInformation')->name('admin_users_manage_modify_information');
    Route::get('/admin/users/generateAuthPassword', 'Admin\UsersController@generateAuthPassword')->name('admin_users_manage_generate_auth_password');
    Route::get('/admin/users/generateAllAuthPassword', 'Admin\UsersController@generateAuthAllPasswords')->name('admin_users_manage_generate_all_auth_password');
    Route::get('/admin/users/userCards/{email}', 'Admin\UsersController@userCards')->name('admin_users_manage_users_cards');

    //Developer 2 code start

    //Developer 2 code 18-02-17
    Route::get('/admin/users/identityListResult', 'Admin\UsersController@listIdentityList')->name('admin_identity_verification_request');

    //Developer code 21-02-07
    Route::get('/admin/users/cardAuthenticationList', 'Admin\UsersController@cardAuthentication')->name('admin_cardauthentication');

    Route::get('/admin/users/cardAuthenticationListResult', 'Admin\UsersController@cardAuthenticationList')->name('admin_card_authentication_request');


    //Developer 2 code end


    Route::post('/admin/users/rejectPersonalVerification', 'Admin\UsersController@rejectPersonalVerification')->name('admin_users_manage_reject_personal_verification');
    Route::post('/admin/users/rejectBusinessVerification', 'Admin\UsersController@rejectBusinessVerification')->name('admin_users_manage_reject_business_verification');

    Route::get('/admin/users/cardAuthenticationInformationAndDocuments/{email}/{cardId}', 'Admin\UsersController@cardAuthenticationInformationAndDocuments')->name('admin_users_manage_users_card_authentication_information_and_documents');
    Route::get('/admin/users/personalVerificationInformationAndDocuments/{email}', 'Admin\UsersController@businessVerificationInformationAndDocuments')->name('admin_users_manage_users_personal_verification_information_and_documents');
    Route::get('/admin/users/businessVerificationInformationAndDocuments/{email}', 'Admin\UsersController@businessVerificationInformationAndDocuments')->name('admin_users_manage_users_business_verification_information_and_documents');
    Route::get('/admin/users/authenticateCardInformation/{email}/{cardId}', 'Admin\UsersController@authenticateCardInformation')->name('admin_users_manage_users_authenticate_card');
    Route::get('/admin/users/deleteCardInformation/{email}/{cardId}', 'Admin\UsersController@deleteCardInformation')->name('admin_users_manage_users_delete_card_information');
    Route::post('/admin/users/deleteCardInformation/{email}/{cardId}', 'Admin\UsersController@deleteCardInformation')->name('admin_users_manage_users_delete_card_information');

    Route::post('/admin/users/rejectCardInformation/{email}/{cardId}', 'Admin\UsersController@rejectCardInformation')->name('admin_users_manage_users_reject_card_information');

    Route::get('/admin/users/deletePersonalVerificationInformation/{email}', 'Admin\UsersController@deletePersonalVerificationInformation')->name('admin_users_manage_users_delete_personal_verification_information');
    Route::get('/admin/users/deleteBusinessVerificationInformation/{email}', 'Admin\UsersController@deleteBusinessVerificationInformation')->name('admin_users_manage_users_delete_business_verification_information');
    Route::post('/admin/users/deleteUserAccount', 'Admin\UsersController@deleteUserAccount')->name('admin_users_delete_user_account');
    Route::post('/admin/users/deleteUserAccountID/', 'Admin\UsersController@deleteUserAccountID');
    Route::get('/admin/users/deleteSuccessRedirect', 'Admin\UsersController@deleteSuccessRedirect')->name('admin_users_delete_user_account_success_redirect');
    Route::get('/admin/users/deleteSelectedSuccessRedirect', 'Admin\UsersController@deleteSelectedSuccessRedirect')->name('admin_users_delete_selected_user_account_success_redirect');
    Route::get('/admin/users/deleteSuccessDashRedirect', 'Admin\UsersController@deleteSuccessDashRedirect')->name('admin_users_delete_user_account_success_dash_redirect');
    Route::get('/admin/commands/list', 'Admin\CommandsController@listCommands')->name('admin_commands_list');
    Route::get('/admin/commands/listResult', 'Admin\CommandsController@listCommandsResult')->name('admin_commands_list_dataset');

    //developer 1
    Route::post('/admin/users/changeUserAccountStatus/', 'Admin\UsersController@changeUserAccountStatus');
    Route::get('/admin/users/statusSuccessRedirect', 'Admin\UsersController@statusSuccessRedirect')->name('admin_users_status_user_account_success_redirect');
    //////


    Route::get('/admin/cards-and-accounts/list', 'Admin\CardsAndAccountsController@listCardsAndAccounts')->name('admin_cards_and_accounts_list');
    Route::get('/admin/cards-and-accounts/listResult', 'Admin\CardsAndAccountsController@listCardsAndAccountsResult')->name('admin_cards_and_accounts_list_dataset');
    Route::post('/admin/cards-and-accounts/delete', 'Admin\CardsAndAccountsController@deleteCardsAndAccounts')->name('admin_cards_and_accounts_delete');
    Route::get('/admin/cards-and-accounts/deleteRedirect', 'Admin\CardsAndAccountsController@deleteSuccessRedirect')->name('admin_cards_and_accounts_success_redirect');

    Route::get('/admin/commands/delete', 'Admin\CommandsController@deleteCommand')->name('admin_commands_delete');
    Route::get('/admin/commands/deleteSuccessRedirect', 'Admin\CommandsController@deleteSuccessRedirect')->name('admin_commands_delete_success_redirect');
    Route::post('/admin/commands/edit-command/{id}', 'Admin\CommandsController@editCommand')->name('admin_commands_edit');
});


Route::group(['middleware' => ['\App\Http\Middleware\UserMiddleware']], function () {
    //All User Routes
    Route::get('/cards', 'User\CardsController@cards');
    Route::get('/user/cards-archived/{command}', 'User\CardsController@predefinedCommand')->name('cards-archived');
    Route::get('/user/card/{command}/{id}', 'User\CardsController@predefinedCommand');
    Route::get('/user/card/{id}-{command}', 'User\CardsController@predefinedCommand');

    Route::post('/user/card-archived/{command}', 'User\CardsController@predefinedEncryCommand');
    Route::get('/user/card-archived/{command}', 'User\CardsController@predefinedEncryCommand');

    // developer 2 code start : 22.02.2017
    Route::get('/user/card-archived-details/{command}', 'User\CardsController@predefinedEncryCommandDetails');
    // developer 2 code end : 22.02.2017

    Route::post('/user/card/{command}/{id}', 'User\CardsController@predefinedCommand');
    Route::get('/cards/add-a-card', 'User\CardsController@addcardView');
    Route::post('/cards/add-a-card', 'User\CardsController@addcard');
    Route::get('/user/cards/validate/{id}', 'User\CardsController@validatecard');
    Route::get('/user/cards/remove/{id}', 'User\CardsController@removecard');
    Route::get('/user/cards/remove-archived/{id}', 'User\CardsController@removeArchivedCard');
    Route::get('/user/cards/removenotice/{id}', 'User\CardsController@removenotice');
    Route::get('/user/cards/authorization/{id}', 'User\CardsController@authorization');
    Route::post('/auth/verify/authorizationPassword', 'User\CardsController@validateAuthPassword');
    Route::get('/user/cards/view', 'User\CardsController@view');
    Route::post('/user/cards/upload/{id}', 'User\CardsController@uploadcard');

    //Developer 2 code starts

    Route::get('/user/my-account/downgrade', 'Dashboard\DashController@downgradeAccount');

    //Developer 2 code end

    Route::get('/send-payment', 'User\SendMoneyController@sendmoneyView');
    Route::post('/send-payment', 'User\SendMoneyController@sendmoney');
    Route::get('/user/sendmoney/fetchtotal', 'User\SendMoneyController@fetchFeeAndTotalAmount');
    Route::get('/user/verify/sendemail', 'User\SendMoneyController@verifySendEmail');

    Route::get('/user/accounts', 'User\AccountsController@accounts');
    Route::get('/user/accounts/addaccount', 'User\AccountsController@addAccount');
    Route::post('user/accounts/createAccount', 'User\AccountsController@createAccount');
    Route::get('/user/accounts/primary/{id}', 'User\AccountsController@makePrimary')->name('account_make_primary');
    Route::get('/user/accounts/remove/{id}', 'User\AccountsController@remove');
    Route::get('/user/accounts/createAccountSuccess', 'User\AccountsController@createAccountSuccess');
    Route::get('/accounts/identityInfoSubmitted', 'User\AccountsController@identityInfoSubmitted');
    Route::get('/user/accounts/verifyAccountAndIdentity/{accountId?}', 'User\AccountsController@verifyAccountAndIdentity')->name('verify_account_identity');
    Route::post('/user/accounts/saveVerificationDetails/{accountId?}', 'User\AccountsController@saveVerificationDetails')->name('save_verification_details');
    Route::get('/user/accounts/authorization/{id}', 'User\AccountsController@authorization');
    Route::post('/user/accounts/duplicateAttempt', 'User\AccountsController@duplicateAttempt')->name('accounts_duplicate_check');
    Route::post('/user/accounts/view', 'User\AccountsController@view');

    /*********/
    Route::get('/bank-accounts', 'User\AccountsController@accounts')->name('bank-accounts');
    Route::get('/bank-accounts/add-a-bank-account', 'User\AccountsController@addAccount');
    Route::post('user/bank-accounts/createAccount', 'User\AccountsController@createAccount');
    Route::get('/user/bank-accounts/primary/{id}', 'User\AccountsController@makePrimary')->name('account_make_primary');
    Route::get('/user/bank-accounts/remove/{id}', 'User\AccountsController@remove');
    Route::get('/user/bank-accounts/remove-archived/{id}', 'User\AccountsController@removeArchived');
    Route::get('/user/bank-accounts/createAccountSuccess', 'User\AccountsController@createAccountSuccess');
    Route::get('/bank-accounts/identityInfoSubmitted', 'User\AccountsController@identityInfoSubmitted');
    Route::get('/user/bank-accounts/verifyAccountAndIdentity/{accountId?}', 'User\AccountsController@verifyAccountAndIdentity')->name('verify_account_identity');
    Route::post('/user/bank-accounts/saveVerificationDetails/{accountId?}', 'User\AccountsController@saveVerificationDetails')->name('save_verification_details');
    Route::get('/user/bank-accounts/authorization/{id}', 'User\AccountsController@authorization');
    Route::post('/user/bank-accounts/duplicateAttempt', 'User\AccountsController@duplicateAttempt')->name('accounts_duplicate_check');
    Route::get('/user/bank-accounts/view', 'User\AccountsController@view');
    Route::get('/user/bank-account/{command}/{id}', 'User\AccountsController@predefinedCommand');
    Route::get('/user/bank-account/{id}-{command}', 'User\AccountsController@predefinedCommand');
    Route::post('/user/bank-account/{command}/{id}', 'User\AccountsController@predefinedCommand');
    /* Route::get('/user/bank-account-archived/{command}/{id}', 'User\AccountsController@predefinedCommand');
     Route::get('/user/bank-account-archived/{key}', 'User\AccountsController@predefinedCommands');
     Route::post('/user/bank-account-archived/{command}/{id}', 'User\AccountsController@predefinedCommand'); */
    Route::get('/user/bank-account-archived/{command}/{id}', 'User\AccountsController@predefinedEncryptCommands');
    Route::get('/user/bank-account-archived/{key}', 'User\AccountsController@predefinedEncryptCommands');

    // developer 2 code start : 22.02.2017
    Route::get('/user/bank-account-archived-details/{key}', 'User\AccountsController@predefinedEncryptCommandsDetails');

    // developer 2 code end : 22.02.2017


    Route::post('/user/bank-account-archived/{command}/{id}', 'User\AccountsController@predefinedEncryptCommands');
    Route::get('/user/bank-accounts-archived/{command}', 'User\AccountsController@predefinedEncryptCommands')->name('bank-accounts-archived');
    Route::get('/withdraw-money', 'User\WithdrawController@withdraw');
    Route::post('/withdraw-money', 'User\WithdrawController@withdrawmoney');
    Route::get('/transaction-history', 'User\TransactionController@transaction');
    Route::get('/user/transaction/dataset', ['as' => 'transaction_dataset', 'uses' => 'User\TransactionController@dataSet']);
    Route::get('/user/transaction/details/{id}', ['as' => 'transaction_details', 'uses' => 'User\TransactionController@details']);
    Route::get('/user/transactiontest', 'User\TransactionController@transactiontest');
    Route::get('/home', 'User\DashboardController@home');
    Route::post('/user/transaction/export-to-pdf', ['as' => 'transaction_current_data_set_to_pdf', 'uses' => 'User\TransactionController@transactionCurrentDataSetExportToPdf']);
    Route::post('/user/transaction/export-to-html', ['as' => 'transaction_current_data_set_to_html', 'uses' => 'User\TransactionController@transactionCurrentDataSetExportToHtml']);

    Route::get('/user/signout', function () {
        Auth::logout();
        return Redirect('/login');
    });

    Route::get('/dashboard', 'Dashboard\DashController@my_account');
    Route::post('/dashboard/change/email', 'Dashboard\DashController@changeemail');  /* change email login user*/
    Route::post('/dashboard/updateEmail', 'Dashboard\DashController@updateEmail');
    Route::get('/dashboard/resend/{email}', 'Dashboard\DashController@resend');
    Route::get('/dashboard/resend-change-email/{email}', 'Dashboard\DashController@resendChangeEmail');
    Route::get('/dashboard/changePassword', 'Dashboard\DashController@changePassword');
    Route::post('/dashboard/changePassword', 'Dashboard\DashController@updatePassword');
    Route::get('/dashboard/changePhone', 'Dashboard\DashController@changePhone');
    Route::post('/dashboard/changePhone', 'Dashboard\DashController@updatePhone');
    Route::get('/dashboard/changeTimezone', 'Dashboard\DashController@changeTimeZone');
    Route::post('/dashboard/changeTimezone', 'Dashboard\DashController@updateTimeZone');
    Route::get('/dashboard/personal', 'Dashboard\DashController@personal');
    Route::get('/dashboard/personal/changeAddress', 'Dashboard\DashController@changeAddress');
    Route::post('/dashboard/personal/changeAddress', 'Dashboard\DashController@updateAddress');
    Route::get('/dashboard/upgrade', 'Dashboard\DashController@upgrade');
    Route::get('/dashboard/upgradeAcc', 'Dashboard\DashController@upgradeAcc');
    Route::post('/dashboard/upgrade', 'Dashboard\DashController@upgradeAccount');
    Route::get('/dashboard/business', 'Dashboard\DashController@business');
    Route::post('/verify/businessUp', 'Dashboard\DashController@businessVerification');
    Route::post('/verify/personalUp', 'Dashboard\DashController@personalVerification');
    Route::get('/verify', 'Dashboard\DashController@verify');
    Route::get('/verify_page', 'Dashboard\VerifyController@verify_page');
    Route::resource('/get_verify', 'Dashboard\VerifyController@get_verify');
    Route::resource('/verify_identity', 'Dashboard\VerifyController@verify_identity');
    Route::post('/user/verify/document/upload/{id}', 'Dashboard\VerifyController@verify_document');
    Route::get('/my-account', 'Dashboard\DashController@my_account');
    Route::get('/verifications', 'Dashboard\DashController@verifications');
    Route::get('/verify/personal-verification', 'Dashboard\DashController@verify_personal_verifications');
    Route::get('/verify/business-verification', 'Dashboard\DashController@verify_business_verifications');
    Route::post('/verifications', 'Dashboard\DashController@submit_final_verificationDoc');

    Route::get('/dashboard/authorization/email/', 'Dashboard\DashController@authorization_email');

    Route::get('/user/confirmation', 'Dashboard\DashController@user_confirmation');
    //auth routes


});


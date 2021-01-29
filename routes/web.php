<?php

/*
|--------------------------------------------------------------------------
| User Authentication Routes
|--------------------------------------------------------------------------
*/




Route::get('/wallet/add/money' ,  'PaymentController@add_money');
Route::get('/wallet/api/verify','PaymentController@api_wallet_verify');
Route::get('/wallet_pay/api','PaymentController@api_paisa_add_money');

Route::get('/flow/paisa/money' ,  'PaymentController@api_paisa_payment_form');
Route::get('/flow/api/verify','PaymentController@api_flow_verify');
Route::get('/flow_pay/api','PaymentController@flow_api_paisa_flow');

//subscription
Route::get('/provider/api/subscription' ,  'PaymentController@api_subscription_verify');
Route::get('/provider/api/verify','PaymentController@api_provider_verify');
Route::get('/provider/subscription/pay','PaymentController@api_subscription_post');


Auth::routes();


//easy paisa wallet
Route::post('/paisa_wallet','HomeController@paisa_wallet_form');
Route::get('/wallet/verify','HomeController@wallet_verify');
Route::get('/wallet_pay','PaymentController@paisa_add_money');
//flowpaisa 

Route::get('/flow/verify','PaymentController@flow_verify');
Route::post('/payment/paisa', 'PaymentController@paisa_payment_form');
Route::get('/confirmflowpay','PaymentController@flow_paisa_flow');

//Api



Route::post('/contact/us', 'HomeController@contactus')->name('contact');
Route::post('/common/socket' , 'SocketController@commonSocket');

Route::get('auth/facebook', 'Auth\SocialLoginController@redirectToFaceBook');
Route::get('auth/facebook/callback', 'Auth\SocialLoginController@handleFacebookCallback');
Route::get('auth/google', 'Auth\SocialLoginController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\SocialLoginController@handleGoogleCallback');
Route::post('account/kit', 'Auth\SocialLoginController@account_kit')->name('account.kit');
Route::get('/citydropdown/{id}','UserApiController@respective_city');
Route::get('/cityvalidate','UserApiController@cityvalidate');
Route::get('/languagechange','UserApiController@languagechange');
Route::get('/countrycodedropdown/{countrycode}','UserApiController@countrycodedropdown');

/*
|--------------------------------------------------------------------------
| Provider Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'provider'], function () {

    Route::get('auth/facebook', 'Auth\SocialLoginController@providerToFaceBook');
    Route::get('auth/google', 'Auth\SocialLoginController@providerToGoogle');

    Route::get('/login', 'ProviderAuth\LoginController@showLoginForm');
    Route::post('/login', 'ProviderAuth\LoginController@login');
    Route::post('/logout', 'ProviderAuth\LoginController@logout');

    Route::get('/register', 'ProviderAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'ProviderAuth\RegisterController@register');

    Route::post('/password/email', 'ProviderAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'ProviderAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'ProviderAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'ProviderAuth\ResetPasswordController@showResetForm');
});

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', 'AdminAuth\LoginController@showLoginForm');
    Route::post('/login', 'AdminAuth\LoginController@login');
    Route::post('/logout', 'AdminAuth\LoginController@logout');

    Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

/*
|--------------------------------------------------------------------------
| Dispatcher Authentication Routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'dispatcher'], function () {
    Route::get('/login', 'DispatcherAuth\LoginController@showLoginForm');
    Route::post('/login', 'DispatcherAuth\LoginController@login');
    Route::post('/logout', 'DispatcherAuth\LoginController@logout');

    Route::post('/password/email', 'DispatcherAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'DispatcherAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'DispatcherAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'DispatcherAuth\ResetPasswordController@showResetForm');
});

/*
|--------------------------------------------------------------------------
| Fleet Authentication Routes
|--------------------------------------------------------------------------
*/


Route::group(['prefix' => 'fleet'], function () {
    Route::get('/login', 'FleetAuth\LoginController@showLoginForm');
    Route::post('/login', 'FleetAuth\LoginController@login');
    Route::post('/logout', 'FleetAuth\LoginController@logout');

    Route::post('/password/email', 'FleetAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'FleetAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'FleetAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'FleetAuth\ResetPasswordController@showResetForm');
});

/*
|--------------------------------------------------------------------------
| Account Authentication Routes
|--------------------------------------------------------------------------
*/


Route::group(['prefix' => 'account'], function () {
    Route::get('/login', 'AccountAuth\LoginController@showLoginForm');
    Route::post('/login', 'AccountAuth\LoginController@login');
    Route::post('/logout', 'AccountAuth\LoginController@logout');

    Route::get('/register', 'AccountAuth\RegisterController@showRegistrationForm');
    Route::post('/register', 'AccountAuth\RegisterController@register');

    Route::post('/password/email', 'AccountAuth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'AccountAuth\ResetPasswordController@reset');
    Route::get('/password/reset', 'AccountAuth\ForgotPasswordController@showLinkRequestForm');
    Route::get('/password/reset/{token}', 'AccountAuth\ResetPasswordController@showResetForm');
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('newindex');
});

Route::get('/initsetup', function () {
    return Setting::all();
});

Route::get('/ride', function () {
    return view('ride');
});


Route::get('/ride', 'Auth\RegisterController@ride');
Route::get('/sendmail', 'SendMailController@index');
Route::post('/sendmail/verify', 'SendMailController@verify')->name('verify');
Route::post('/sendmail/createusers', 'SendMailController@createusers')->name('createusers');
Route::get('/sendmail/form', 'SendMailController@showmailform')->name('showmailform');

Route::get('/drive', function () {
    return view('drive');
});

Route::get('privacy', function () {
    $page = 'page_privacy';
    $title = 'Privacy Policy';
    return view('static', compact('page', 'title'));
});

Route::get('terms', function () {
    $page = 'terms';
    $title = 'Terms and Conditions';
    return view('static', compact('page', 'title'));
});
Route::get('cancellation', function () {
    $page = 'cancel';
    $title = 'Cancellation Rules';
    return view('static', compact('page', 'title'));
});

Route::get('help', function () {
    $page = 'help';
    $title = 'Help';
    return view('static', compact('page', 'title'));
});


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', 'HomeController@index');
Route::get('/hour/{id}', 'UserApiController@pricing_logic');

// user profiles
Route::get('/profile', 'HomeController@profile');
Route::get('/edit/profile', 'HomeController@edit_profile');
Route::post('/profile', 'HomeController@update_profile');

// update password
Route::get('/change/password', 'HomeController@change_password');
Route::post('/change/password', 'HomeController@update_password');

// ride
Route::get('/confirm/ride', 'RideController@confirm_ride');
Route::post('/create/ride', 'RideController@create_ride');
Route::post('/cancel/ride', 'RideController@cancel_ride');
Route::get('/onride', 'RideController@onride');
Route::post('/payment', 'PaymentController@payment');

Route::get('/easy_pay', 'PaymentController@easyPay')->name('easy_pay');
Route::post('/rate', 'RideController@rate');

// status check
Route::get('/status', 'RideController@status');
Route::get('/user/incoming', 'HomeController@incoming');


// trips
Route::get('/trips', 'HomeController@trips');
Route::get('/upcoming/trips', 'HomeController@upcoming_trips');

// wallet
Route::get('/wallet', 'HomeController@wallet');
Route::post('/add/money', 'PaymentController@add_money');

// payment
Route::get('/payment', 'HomeController@payment');

// card
Route::resource('card', 'Resource\CardResource');

// promotions
Route::get('/promotions', 'HomeController@promotions_index')->name('promocodes.index');
Route::post('/promotions', 'HomeController@promotions_store')->name('promocodes.store');

Route::post('/fare' , 'UserApiController@fare');

Route::post('/request/payment_change','UserApiController@flow_payment_change');

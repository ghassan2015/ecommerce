<?php



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Dealer', 'middleware' => 'auth:dealer', 'prefix' => 'dealer'], function () {

    Route::get('/', 'DashboradController@index')->name('dealer.dashboard');  // the first page admin visits if authenticated
    Route::get('logout', 'DashboradController@logout')->name('admin.logout');
});
Route::group(['namespace' => 'Dealer\Auth', 'middleware' => 'guest:dealer', 'prefix' => 'dealer'], function () {
    Route::get('register', 'RegisterController@formRegister')->name('dealer.register');
    Route::post('register', 'RegisterController@create')->name('dealer.post.register');
    Route::get('login', 'LoginController@login')->name('dealer.login');
    Route::post('login', 'LoginController@postLogin')->name('dealer.post.login');
    Route::post('/password/email', 'DealerForgotPasswordController@sendResetLinkEmail')->name('dealer.password.email');
    Route::get('/password/reset', 'DealerForgotPasswordController@showLinkRequestForm')->name('dealer.password.request');
    Route::post('/password/reset', 'DealerResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'DealerResetPasswordController@showResetForm')->name('dealer.password.reset');

});

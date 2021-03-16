<?php



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect']],function () {

    Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
        Route::get('/', 'DashboradController@index')->name('admin.dashboard');  // the first page admin visits if authenticated
        Route::get('logout', 'DashboradController@logout')->name('admin.logout');
    });
    Route::group(['namespace' => 'Admin\Auth', 'middleware' => 'guest:admin', 'prefix' => 'admin'], function () {
        Route::get('login', 'LoginController@login')->name('admin.login');
        Route::post('login', 'LoginController@postLogin')->name('admin.post.login');
        Route::post('/password/email', 'AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
        Route::get('/password/reset', 'AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
        Route::post('/password/reset', 'AdminResetPasswordController@reset');
        Route::get('/password/reset/{token}', 'AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    });

    Route::group(['namespace' => 'Admin\Category', 'middleware' => 'auth:admin', 'prefix' => 'admin/maincategories'], function () {
      //start Category
        Route::get('/','CategoryController@index')->name('admin.category');
        Route::get('/create/','CategoryController@edit')->name('admin.maincategory.create');
        Route::post('/','CategoryController@store')->name('admin.maincategory.store');
        Route::get('/edit/{id}','CategoryController@edit')->name('admin.maincategory.edit');
        Route::post('update/{id}','CategoryController@update')->name('admin.maincategory.update');
        Route::get('/delete/{id}','CategoryController@destroy')->name('admin.maincategory.destroy');
//end Category



    });
    });

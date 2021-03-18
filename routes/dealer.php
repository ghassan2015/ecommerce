<?php



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['namespace' => 'Dealer', 'middleware' => 'auth:dealer', 'prefix' => 'dealer'], function () {

    Route::get('/', 'DashboradController@index')->name('dealer.dashboard');  // the first page admin visits if authenticated
Route::get('/information/{id}','InformationDealer@information')->name('dealer_information');
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

Route::group(['namespace' => 'Dealer\Auth', 'middleware' => 'auth:dealer', 'prefix' => 'dealer/'], function () {
    Route::get('logout', 'LoginController@logout')->name('dealer.logout');
});
Route::group(['namespace' => 'Dealer', 'middleware' => 'auth:dealer', 'prefix' => 'dealer/profile'], function () {
    Route::get('/', 'ProfileController@editProfile')->name('dealer.profile');
    Route::put('/', 'ProfileController@updateProfile')->name('update.profile');
});
Route::group(['namespace' => 'Dealer','prefix' => 'products'], function () {
    Route::get('/', 'ProductController@index')->name('admin.products');
    Route::get('general-information', 'ProductController@create')->name('admin.products.general.create');
    Route::post('store-general-information', 'ProductController@store')->name('admin.products.general.store');

    Route::get('price/{id}', 'ProductController@getPrice')->name('admin.products.price');
    Route::post('price', 'ProductController@saveProductPrice')->name('admin.products.price.store');

    Route::get('stock/{id}', 'ProductController@getStock')->name('admin.products.stock');
    Route::post('stock', 'ProductController@saveProductStock')->name('admin.products.stock.store');

    Route::get('images/{id}', 'ProductController@addImages')->name('admin.products.images');
    Route::post('images', 'ProductController@saveProductImages')->name('admin.products.images.store');
    Route::post('images/db', 'ProductController@saveProductImagesDB')->name('admin.products.images.store.db');
});


<?php



Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect']],function () {

    Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin', 'prefix' => 'admin'], function () {
        Route::get('/', 'DashboradController@index')->name('admin.dashboard');
        Route::group(['prefix' => 'sliders'], function () {
            Route::get('/', 'SliderController@addImages')->name('admin.sliders.create');
            Route::post('images', 'SliderController@saveSliderImages')->name('admin.sliders.images.store');
            Route::post('images/db', 'SliderController@saveSliderImagesDB')->name('admin.sliders.images.store.db');

        });// the first page admin visits if authenticated
    });

    Route::group(['namespace' => 'Admin', 'middleware' => 'auth:admin', 'prefix' => 'admin/profile'], function () {
        Route::get('/', 'ProfileController@editProfile')->name('admin.profile');
        Route::put('/', 'ProfileController@updateProfile')->name('update.profile');
    });
    //start Category

    Route::group(['namespace' => 'Admin\Category', 'middleware' => 'auth:admin', 'prefix' => 'admin/maincategories'], function () {
        Route::get('/','CategoryController@index')->name('admin.maincategory');
        Route::get('/create/','CategoryController@create')->name('admin.maincategory.create');
        Route::post('/','CategoryController@store')->name('admin.maincategory.store');
        Route::get('/edit/{id}','CategoryController@edit')->name('admin.maincategory.edit');
        Route::post('update/{id}','CategoryController@update')->name('admin.maincategory.update');
        Route::get('/delete/{id}','CategoryController@destroy')->name('admin.maincategory.destroy');
    });
    //end Category

    //start Brand
    Route::group(['namespace' => 'Admin\Brands', 'middleware' => 'auth:admin', 'prefix' => 'admin/brands'], function () {
        Route::get('/','BrandController@index')->name('admin.brands');
        Route::get('/create/','BrandController@create')->name('admin.brands.create');
        Route::post('/','BrandController@store')->name('admin.brands.store');
        Route::get('/edit/{id}','BrandController@edit')->name('admin.brands.edit');
        Route::post('update/{id}','BrandController@update')->name('admin.brands.update');
        Route::get('/delete/{id}','BrandController@destroy')->name('admin.brands.delete');
    });
    //end Brand

    //start Tag
    Route::group(['namespace' => 'Admin\Tag', 'middleware' => 'auth:admin', 'prefix' => 'admin/tags'], function () {
        Route::get('/','TagController@index')->name('admin.tags');
        Route::get('/create/','TagController@create')->name('admin.tags.create');
        Route::post('/','TagController@store')->name('admin.tags.store');
        Route::get('/edit/{id}','TagController@edit')->name('admin.tags.edit');
        Route::post('update/{id}','TagController@update')->name('admin.tags.update');
        Route::get('/delete/{id}','TagController@destroy')->name('admin.tags.delete');
    });
    //end Tag
    Route::group(['namespace' => 'Admin\Attribute', 'middleware' => 'auth:admin', 'prefix' => 'admin/attributes'], function () {
        Route::get('/','AttributeController@index')->name('admin.attributes');
        Route::get('/create/','AttributeController@create')->name('admin.attributes.create');
        Route::post('/','AttributeController@store')->name('admin.attributes.store');
        Route::get('/edit/{id}','AttributeController@edit')->name('admin.attributes.edit');
        Route::post('update/{id}','AttributeController@update')->name('admin.attributes.update');
        Route::get('/delete/{id}','AttributeController@destroy')->name('admin.attributes.delete');
    });
    Route::group(['namespace' => 'Admin\Auth', 'middleware' => 'auth:admin', 'prefix' => 'admin/'], function () {
        Route::get('logout', 'LoginController@logout')->name('admin.logout');
    });
    Route::group(['namespace' => 'Admin\Auth', 'middleware' => 'guest:admin', 'prefix' => 'admin'], function () {
        Route::get('login', 'LoginController@login')->name('admin.login');
        Route::post('login', 'LoginController@postLogin')->name('admin.post.login');
        Route::post('/password/email', 'AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
        Route::get('/password/reset', 'AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
        Route::post('/password/reset', 'AdminResetPasswordController@reset');
        Route::get('/password/reset/{token}', 'AdminResetPasswordController@showResetForm')->name('admin.password.reset');
    });
});

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\Category;
use App\Models\Dealer;
use App\Models\Product;

Route::get('/test', function () {

return     view('front.site');
});

//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/website', 'Front\DashboardController@index');
Route::get('/category/{id}', 'Front\DashboardController@showCategory')->name('category');
Route::get('product/details/{slug}','Front\DashboardController@showDeatails')->name('product.details');

Route::group(['namespace' => 'Front', 'middleware' => 'auth'], function () {
    Route::post('wishlist', 'WishlistController@store')->name('wishlist.store');
    Route::delete('wishlist', 'WishlistController@destroy')->name('wishlist.destroy');
    Route::get('wishlist/products', 'WishlistController@index')->name('wishlist.products.index');
    Route::get('products/{productId}/reviews', 'ProductReviewController@index')->name('products.reviews.index');
    Route::post('products/{productId}/reviews', 'ProductReviewController@store')->name('products.reviews.store');
    Route::get('payment/{amount}', 'PaymentController@getPayments') -> name('payment');
    Route::post('payment', 'PaymentController@processPayment') -> name('payment.process');
    Route::group(['prefix' => 'cart'], function () {
         Route::get('/', 'CartController@getIndex')->name('site.cart.index');
        Route::post('/cart/add/{slug?}', 'CartController@postAdd')->name('site.cart.add');
        Route::post('/update/{slug}', 'CartController@postUpdate')->name('site.cart.update');
        Route::post('/update-all', 'CartController@postUpdateAll')->name('site.cart.update-all');
    });
});

Route::get('/category/new', 'Front\DashboardController@showNewArrivls');

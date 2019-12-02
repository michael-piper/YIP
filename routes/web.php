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

Route::get('/','ScreenController@home');
Route::get('/home', 'ScreenController@home');
Route::get('/contactus', 'ScreenController@contactus');
Route::get('/cart', 'ScreenController@cart');
Route::post('/cart/checkout', 'ScreenController@cartCheckout');
Route::get('/orders','ScreenController@orders');
Route::get('/orders/{order_id}','ScreenController@order');
Route::get('/verify-payment','ScreenController@verifyPayment');
Route::get('/dashboard','ScreenController@dashboard');
Route::get('/add_to_cart/{product_id}', 'ScreenController@addCartItem');
Route::get('/add_to_cart/{product_id}/{quantity}', 'ScreenController@addToCart');
Route::get('/remove_from_cart/{product_id}', 'ScreenController@removeCartItem');
Route::get('/remove_from_cart/{product_id}/{quantity}', 'ScreenController@removeFromCart');
Route::get('/shop', 'ScreenController@shop');
Route::get('/shop/product-{product_id}/{product_name?}', 'ScreenController@shopItem');
Route::get('/login', 'ScreenController@login');
Route::post('/login', 'ScreenController@doLogin');
Route::any('/logout', 'ScreenController@logout');
Route::get('/signup', 'ScreenController@signup');
Route::post('/signup', 'ScreenController@doSignup');
Route::get('/signup_vendor', 'ScreenController@signupVendor');
Route::post('/signup_vendor', 'ScreenController@doSignupVendor');
Route::get('/forgetpassword', 'ScreenController@forgetPassword');
Route::post('/forgetpassword', 'ScreenController@doForgetPassword');
Route::apiResource('account/contacts', 'AccountContactController');

Route::group(['prefix' => 'dashboard','middleware' => ['auth.vendor-admin']], function(){
    Route::get('/products', 'DashboardController@products');
    Route::get('/orders', 'DashboardController@orders');
    Route::get('/categories', 'DashboardController@categories');
    Route::get('/cars-make-model', 'DashboardController@carsMakeAndModel');
    Route::get('/sub_categories', 'DashboardController@subCategories');
    Route::get('/add_product', 'DashboardController@addProduct');
    Route::get('/product_status', 'DashboardController@productStatus');
    Route::get('/order_status', 'DashboardController@orderStatus');
    Route::post('/add_product', 'DashboardController@doAddProduct');
    Route::get('/product/{product_id}', 'DashboardController@product');
    Route::get('/edit_product/{product_id}', 'DashboardController@editProduct');
    Route::post('/edit_product/{product_id}', 'DashboardController@doEditProduct');
});

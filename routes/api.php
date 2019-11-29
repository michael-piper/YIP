<?php

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use App\UserDetail;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'v1','namespace' => 'APIv1'], function(){
    Route::any("/",'AddonsController@Documentation');
    Route::get('/migrate','AddonsController@Migrate');
    Route::get("/product/autofill/{id}/{where?}={value?}",'AddonsController@AutoFillById')->where('id','[0-9]+');
    Route::get("/product/autofill/{name}/{where?}={value?}",'AddonsController@AutoFillByName')->where('name','[A-Z\_\-\.a-z0-9]+');
    Route::get("/product/subcategory/category={id}",'AddonsController@ProductSubCategoryByCatId');
    Route::get("/product/subcategory/{id}",'AddonsController@ProductSubCategoryById');
    Route::get("/product/category/{id}",'AddonsController@ProductCategoryById');
    Route::get("/product/status/{id}",'AddonsController@ProductStatusById')->where('id','[0-9]+');
    Route::get("/product/subcategory",'AddonsController@ProductSubCategory');
    Route::get("/product/category",'AddonsController@ProductCategory');
    Route::get("/product/status",'AddonsController@ProductStatus');
    Route::get("/product/{id}",'AddonsController@ProductById')->where('id','[0-9]+');
    Route::get("/product/{name}",'AddonsController@ProductByName')->where('name','[A-Z\_\-\.\sa-z0-9]+');
    Route::get("/product",'AddonsController@Product');
    Route::apiResource('session', 'SessionController');
    Route::get('otp/{username}', 'OTPController@confirm');
    Route::post('otp/{username}', 'OTPController@create');
    Route::apiResource('otp', 'OTPController');
});
Route::middleware(['auth.api'])->group(function () {
    //
    static $user;
    $user=User::from_api_token();
    if($user && $user->type==3 ){
        Route::group(['prefix' => 'v1','namespace' => 'APIv1\Admin'], function(){
            Route::apiResource('products', 'ProductController');
            Route::apiResource('categories', 'CategoryController');
            Route::apiResource('sub_categories', 'SubCategoryController');
            Route::apiResource('cars-make-model', 'CarsMakeAndModelController');
            Route::apiResource('orders', 'OrderController');
            Route::apiResource('websites', 'WebsiteController');
            Route::apiResource('components', 'ComponentController');
            Route::apiResource('articles', 'ArticleController');
            Route::apiResource('webplugins', 'WebPluginController');
        });
    }
    elseif( $user && $user->type==2){
        Route::group(['prefix' => 'v1','namespace' => 'APIv1\Vendor'], function(){
            Route::apiResource('products', 'ProductController');

            Route::apiResource('orders', 'OrderController');
            Route::apiResource('websites', 'WebsiteController');
            Route::apiResource('components', 'ComponentController');
            Route::apiResource('articles', 'ArticleController');
            Route::apiResource('webplugins', 'WebPluginController');
        });
    }
    else{
        Route::get('{a22}',function() use($user){
            return response()->json([$user]);
        });
    }


});



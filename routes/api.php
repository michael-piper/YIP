<?php

use Illuminate\Http\Request;

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
    Route::get('/migrate',function(){
        $start=microtime(true);
        if(isset($_GET['key'])){
            $key=str_split($_GET['key']);
            sort($key);
            $key=implode('',$key);
            if($key =="aaceeehiiilmmmnpprsy"){
                $migrate=[
                    "select id from product_status where id =1"=>
                    "INSERT INTO `product_status`
                    (`id`,`name`,`description`)
                    VALUES
                    ('1','New','new items')
                    ",
                    "select id from product_status where id =2"=>
                    "INSERT INTO `product_status`
                    (`id`,`name`,`description`)
                    VALUES
                    ('2','Used','used items'),
                    ('3','Tokunbo','imported used items')
                    ",
                    "select id from product_status where id =3"=>
                    "INSERT INTO `product_status`
                    (`id`,`name`,`description`)
                    VALUES
                    ('3','Tokunbo','imported used items')
                    ",
                    "select id from product_categories where id =1"=>
                    "INSERT INTO `product_categories`
                    (`id`,`name`,`description`)
                    VALUES
                    ('1','Used','used items')
                    ",
                    "select id from product_categories where id =2"=>
                    "INSERT INTO `product_categories`
                    (`id`,`name`,`description`)
                    VALUES
                    ('2','Used','used items')
                    ",
                    "select id from product_sub_categories where id =1"=>
                    "INSERT INTO `product_sub_categories`
                    (`id`,`category_id`,`name`,`description`)
                    VALUES
                    ('1',1,'New','new items')
                    ",
                    "select id from product_sub_categories where id =2"=>
                    "INSERT INTO `product_sub_categories`
                    (`id`,`category_id`,`name`,`description`)
                    VALUES
                    ('2',2,'Used','used items')
                    ",
                    "select id from product_sub_categories where id =3"=>
                    "INSERT INTO `product_sub_categories`
                    (`id`,`category_id`,`name`,`description`)
                    VALUES
                    ('3',2,'Tokunbo','imported used items')
                    "
                ];
                \Artisan::call('migrate', ['--force' => true]);
                $a = 'migrate start <br/><br/>';
                foreach($migrate as $check=>$state){

                    $time=microtime(true);
                    $results = DB::select($check);
                    if(empty($results)){
                        DB::statement($state);
                        $a.="$state took ".(microtime(true)-$time)."<br>";
                    }
                    else{
                        $a.="$check took ".(microtime(true)-$time)."<br>";
                    }
                }
                $a.='migrate took '.(microtime(true)-$start)."sec";
                return $a;
            }
        }
    });
    Route::any("/",'AddonsController@Documentation');
    Route::get("/product/autofill/{id}/{where?}={value?}",'AddonsController@AutoFillById')->where('id','[0-9]+');
    Route::get("/product/autofill/{name}/{where?}={value?}",'AddonsController@AutoFillByName')->where('name','[A-Z\_\-\.a-z0-9]+');
    Route::get("/product/subcategory/category={id}",'AddonsController@ProductSubCategoryByCatId');
    Route::get("/product/subcategory/{id}",'AddonsController@ProductSubCategoryById');
    Route::get("/product/category/{id}",'AddonsController@ProductCategoryById');
    Route::get("/product/subcategory",'AddonsController@ProductSubCategory');
    Route::get("/product/category",'AddonsController@ProductCategory');
    Route::get("/product/status",'AddonsController@ProductStatus');
    Route::get("/product/{id}",'AddonsController@ProductById')->where('id','[0-9]+');
    Route::get("/product/{name}",'AddonsController@ProductByName')->where('name','[A-Z\_\-\.\sa-z0-9]+');
    Route::get("/product",'AddonsController@Product');
    Route::get('/session',function(Request $request){
        return  response()->json(['header'=>getallheaders(),'user'=>\App\User::from_api_token()]);
    });
    Route::post('/session',function(Request $request){
        return  response()->json(['header'=>getallheaders(),'user'=>\App\User::from_api_token()]);
    });
});
Route::group(['prefix' => 'v1','namespace' => 'APIv1\Admin','middleware' => ['auth.api','auth.admin']], function(){
    Route::apiResource('users', 'UserController');
    Route::apiResource('pages', 'PageController');
    Route::apiResource('websites', 'WebsiteController');
    Route::apiResource('components', 'ComponentController');
    Route::apiResource('articles', 'ArticleController');
    Route::apiResource('webplugins', 'WebPluginController');
});
Route::group(['prefix' => 'v1','namespace' => 'APIv1\Vendor','middleware' => ['auth.api','auth.vendor']], function(){
    Route::apiResource('products', 'ProductController');
    Route::apiResource('pages', 'PageController');
    Route::apiResource('websites', 'WebsiteController');
    Route::apiResource('components', 'ComponentController');
    Route::apiResource('articles', 'ArticleController');
    Route::apiResource('webplugins', 'WebPluginController');
});

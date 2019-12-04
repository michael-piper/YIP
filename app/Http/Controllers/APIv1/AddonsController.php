<?php

namespace App\Http\Controllers\APIv1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\ProductCategory;
use App\ProductSubCategory;
use App\ProductAutoFill;
use App\Product;
use App\ProductStatus;
use App\User;
use App\UserDetail;
class AddonsController extends Controller
{
    //
    function Documentation(){
        return response()->json([
            "version"=>"v1.0",
            "url"=>url(''),
            "description"=>User::from_api_token(),
        ]);
    }
    function Migrate(){
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
                    ",
                    "select id from users where id=0"=>
                    "INSERT INTO `users`
                    (`id`,`display_name`, `email`, `phone`, `password`, `display_type`, `type`, `status`, `api_token`, `active`)
                    VALUES
                    (0,'Anonymous', 'anonymous@motopartsarena.com','23470903164', '"
                    .bcrypt('password1')
                    ."', 'Anonymous', '0', '0', '".time().Str::random(22)."', '0');
                    "
                ];
                if(User::where('email','info@motopartsarena.com')->first()==null){
                    $newuser= new User();
                    $newuser->display_name="Motoparts Arena";
                    $newuser->email="info@motopartsarena.com";
                    $newuser->phone="2349031704764";
                    $newuser->type=3;
                    $newuser->display_type="Admin";
                    $newuser->api_token=time().Str::random(22);
                    $newuser->password=bcrypt('password1');
                    if($newuser->save() && $newuser->refresh()){
                        $addons=(object)["address"=>"address","contact_person"=>'admin','state'=>'Lagos','id_card_type'=>'national ID Card','id_card_number'=>'21221902912120921'];
                        $contact=(object)[];
                        $newuser_detail=new UserDetail();
                        $newuser_detail->user_id=$newuser->id;
                        $newuser_detail->addons=json_encode($addons);
                        $newuser_detail->contact=json_encode($contact);
                        $newuser_detail->save();
                    }
                }

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
    }
    function Product(){
        return response()->json(Product::where('active',1)->get());
    }
    function ProductById($id){
        return response()->json(Product::where(['active'=>1,'id'=>$id])->first());
    }
    function ProductByName($name){
        return response()->json(Product::where(['active'=>1,'name'=>$name])->first());
    }
    function ProductStatus(){
        return response()->json(ProductStatus::where('active',1)->get());
    }
    function ProductStatusById($id){
        return response()->json(ProductStatus::where(['active'=>1,'id'=>$id])->first());
    }
    function ProductCategory(){
        return response()->json(ProductCategory::where('active',1)->get());
    }
    function ProductCategoryById($id){
        return response()->json(ProductCategory::where(['active'=>1,'id'=>$id])->first());
    }
    function ProductSubCategory(){
        return response()->json(ProductSubCategory::where('active',1)->get());
    }
    function ProductSubCategoryById($id){
        return response()->json(ProductSubCategory::where(['active'=>1,'id'=>$id])->first());
    }
    function ProductSubCategoryByCatId($id){
        return response()->json(ProductSubCategory::where(['active'=>1,'category_id'=>$id])->get());
    }
    static function AutoFillById(Request $request,$id,$where=null,$value=null){
        $data=null;
        $autofills=ProductAutoFill::where(['id'=>$id])->first();
        if(!is_null($autofills)){
            $data=json_decode($autofills->value,true);
            $norepeat=$request->query('norepeat');
            if($where!=null && $value!=null){
                $data_res=[];
                $data_norepeat=[];
                foreach($data as $result){
                    if(array_key_exists($where,$result) && $result[$where]==$value){
                        if($norepeat){
                            if(array_key_exists($norepeat,$result)){
                                // check if no repeat already declared
                                if(!array_key_exists($result[$norepeat],$data_norepeat)){
                                    $data_res[]=$result;
                                }
                                $data_norepeat[$result[$norepeat]]=null;
                            }
                        }else{
                            $data_res[]=$result;
                        }
                    }
                }
                return response()->json($data_res);
            }else{
                if($norepeat){
                    $data_res=[];
                    $data_norepeat=[];
                    foreach($data as $result){
                       if(array_key_exists($norepeat,$result)){
                            // check if no repeat already declared
                            if(!array_key_exists($result[$norepeat],$data_norepeat)){
                                $data_res[]=$result;
                            }
                            $data_norepeat[$result[$norepeat]]=null;
                        }else{
                            // do nothing
                        }
                    }
                    return response()->json($data_res);
                }
            }
        }
        return response()->json($data);
    }
    function AutoFillByName(Request $request,$name,$where=null,$value=null){
        $data=null;
        $autofills=ProductAutoFill::where(['name'=>$name])->first();
        if(!is_null($autofills)){
            $data=json_decode($autofills->value,true);
            $norepeat=$request->query('norepeat');
            if($where!=null && $value!=null){
                $data_res=[];
                $data_norepeat=[];
                foreach($data as $result){
                    if(array_key_exists($where,$result) && $result[$where]==$value){
                        if($norepeat){
                            if(array_key_exists($norepeat,$result)){
                                // check if no repeat already declared
                                if(!array_key_exists($result[$norepeat],$data_norepeat)){
                                    $data_res[]=$result;
                                }
                                $data_norepeat[$result[$norepeat]]=null;
                            }
                        }else{
                            $data_res[]=$result;
                        }
                    }
                }
                return response()->json($data_res);
            }else{
                if($norepeat){
                    $data_res=[];
                    $data_norepeat=[];
                    foreach($data as $result){
                       if(array_key_exists($norepeat,$result)){
                            // check if no repeat already declared
                            if(!array_key_exists($result[$norepeat],$data_norepeat)){
                                $data_res[]=$result;
                            }
                            $data_norepeat[$result[$norepeat]]=null;
                        }else{
                            // do nothing
                        }
                    }
                    return response()->json($data_res);
                }
            }
        }
        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers\APIv1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductCategory;
use App\ProductSubCategory;
use App\ProductAutoFill;
use App\Product;
use App\User;
class AddonsController extends Controller
{
    //
    function Documentation(){
        return response()->json([
            "version"=>"v1.0",
            "description"=>User::from_api_token(),
        ]);
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

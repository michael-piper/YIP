<?php

namespace App\Http\Controllers\APIv1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\ProductStatus;
class ProductStatusController extends Controller
{
    //
    public function index()
    {

        $product_status= ProductStatus::all();

        return response()->json([
            'error' => false,
            'data'  =>$product_status,
        ], 200);
    }
    public function store(Request $request){
        $values=$request->only('name','description');
        if(is_null($values['name'])){
            return response()->json([
                'error' => true,
                'message'  => "Product Status name required",
            ], 200);
        }
        $product_status= new ProductStatus;
        $product_status->name=$request->name;
        $product_status->description=$request->description;
        $product_status->save();
        return response()->json([
            'error' => false,
            'message'  => "Product Status successfully created",
        ], 200);
    }
    public function show($id){
        $product_status = ProductStatus::where(['id'=>$id])->first();
        if(is_null($product_status)){
            return response()->json([
                'error' => true,
                'message'  => "Product Status with id # $id not found",
            ], 404);
        }
        return response()->json([
            'error' => false,
            'data'  => $product_status,
        ], 200);
    }
    public function update(Request $request, $id){
        $values=$request->only('name','description');
        if(is_null($values['name'])){
            return response()->json([
                'error' => true,
                'message'  => "Product Status name required",
            ], 200);
        }
        $product_status= ProductStatus::where('id',$id)->first();
        if(is_null($product_status)){
            return response()->json([
                'error' => true,
                'message'  => "Product Status with id # $id not found",
            ], 404);
        }
        $product_status->name=$request->name;
        $product_status->description=$request->description;
        $product_status->save();
        return response()->json([
            'error' => false,
            'message'  => "Product Status successfully updated",
        ], 200);
    }
    public function destroy($id)
    {
        $product_status  = ProductStatus::where(['id'=>$id])->first();
        if(is_null($product_status)){
            return response()->json([
                'error' => true,
                'message'  => "Product Status with id # $id not found",
            ], 404);
        }
        $product_status ->delete();
        return response()->json([
            'error' => false,
            'message'  => "Product Status successfully deleted id # $id",
        ], 200);
    }
}

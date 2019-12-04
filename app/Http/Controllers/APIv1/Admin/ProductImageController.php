<?php

namespace App\Http\Controllers\APIv1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductPhoto;
class ProductImageController extends Controller
{
    //
    function index($product_id){
        $images=ProductPhoto::where('product_id',$product_id)->get();
        return response()->json([
            'error' => false,
            'data'  => $images,
        ], 200);
    }
    public function store(Request $request, $product_id){
        $product_photo = new ProductPhoto;
        if($request->hasFile("image")){
            $image = $request->file("image");
            $product_photo->addImage($image);
            $product_photo->product_id=$product_id;
            $product_photo->save();
            return response()->json([
                'error' => false,
                'message'  => 'Product image added',
            ], 200);
        }
        return response()->json([
            'error' => true,
            'message'  => 'Product data sent to server doesn\'t contain Image',
        ], 200);
    }
    function show($product_id, $photo_id){

        $image=ProductPhoto::where(['product_id'=>$product_id,'id'=>$photo_id])->first();
        if(is_null($image)){
            return response()->json([
                'error' => true,
                'message'  => "Product Image with id # $photo_id not found",
            ], 404);
        }
        return response()->json([
            'error' => false,
            'data'  => $image,
        ], 200);
    }
    public function destroy( $product_id, $photo_id){
        $product_photo = ProductPhoto::where('id',$photo_id)->first();
        if(is_null($product_photo)){
            return response()->json([
                'error' => true,
                'message'  => "Product Image with id # $photo_id not found",
            ], 404);
        }
        $product_photo->removeImage();
        $product_photo->delete();
        return response()->json([
            'error' => false,
            'message'  => "Product Image successfully deleted id # $photo_id",
        ], 200);
    }
}

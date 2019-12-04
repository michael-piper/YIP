<?php

namespace App\Http\Controllers\APIv1\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductPhoto;
use App\Product;
class ProductImageController extends Controller
{
    //
    function index($product_id){
        $user=User::from_api_token();
        $product=Product::where('id',$product_id)->first();
        if(is_null($product)){
            return response()->json([
                'error' => true,
                'message'  => 'Product doesn\'t exist',
            ], 200);
        }
        if($product->user_id!=$user->id){
            return response()->json([
                'error' => true,
                'message'  => 'Product doesn\'t belong to '.$user->display_name,
            ], 200);
        }
        $images=ProductPhoto::where('product_id',$product_id)->get();
        return response()->json([
            'error' => false,
            'data'  => $images,
        ], 200);
    }
    public function store(Request $request, $product_id){
        $user=User::from_api_token();
        $product=Product::where('id',$product_id)->first();
        if(is_null($product)){
            return response()->json([
                'error' => true,
                'message'  => 'Product doesn\'t exist',
            ], 200);
        }
        if($product->user_id!=$user->id){
            return response()->json([
                'error' => true,
                'message'  => 'Product doesn\'t belong to '.$user->display_name,
            ], 200);
        }
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
        $user=User::from_api_token();
        $product=Product::where('id',$product_id)->first();
        if(is_null($product)){
            return response()->json([
                'error' => true,
                'message'  => 'Product doesn\'t exist',
            ], 200);
        }
        if($product->user_id!=$user->id){
            return response()->json([
                'error' => true,
                'message'  => 'Product doesn\'t belong to '.$user->display_name,
            ], 200);
        }
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
        $user=User::from_api_token();
        $product=Product::where(['product_id'=>$product_id,'id'=>$photo_id])->first();
        if(is_null($product)){
            return response()->json([
                'error' => true,
                'message'  => 'Product doesn\'t exist',
            ], 200);
        }
        if($product->user_id!=$user->id){
            return response()->json([
                'error' => true,
                'message'  => 'Product doesn\'t belong to '.$user->display_name,
            ], 200);
        }
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

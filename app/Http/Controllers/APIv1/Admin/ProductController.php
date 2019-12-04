<?php

namespace App\Http\Controllers\APIv1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Product;
use App\ProductStatus;
use App\ProductAvailable;
use App\ProductCategory;
use App\ProductSubCategory;
class ProductController extends Controller
{
    //
    public function index()
    {
        $products=Product::all();
        if(count($products)>0){
            foreach($products as $key=>$product){
                $products[$key]->owner=User::where('id',$product->user_id)->first();
                $products[$key]->condition=ProductStatus::where('id',$product->condition)->first();
                $products[$key]->category=ProductCategory::where('id',$product->category_id)->first();
                $products[$key]->sub_category=ProductSubCategory::where('id',$product->sub_category_id)->first();
            }
        }
        return response()->json([
            'error' => false,
            'data'  => $products,
        ], 200);
    }
    public function store(Request $request)
    {
        $message_type='error';
        $message='Email or Password Invalid!';
        $credentials = $request->only(
            'name',
            'price',
            'discount',
            'quantity',
            'category',
            'subcategory',
            'make',
            'model',
            'year',
            'condition',
            'description','image');
        $validation = Validator::make($credentials,[
            'name'=>'required',
            'price'=>'required',
            'quantity'=>'required',
            'category' => 'required',
            'subcategory' => 'required',
            'make'=>'required',
            'model'=>'required',
            'year'=>'required',
            'condition'=>'required',
            'image'=>'required'
        ]);

        if($validation->fails()){
            $errors=$validation->errors();
            foreach ($errors->all() as $message) {
                break;
            }

        }else{
            $wait=ActionController::tryAddProduct($request);
            if($wait){
                $message_type="success";
                $message="product added";
                if($request->quantity){
                    $wait=ActionController::tryAddProductQuantity($wait->id,$request->quantity);
                    if($wait){
                        $message_type="success";
                        $message="product added with ".$request->quantity." in stock";
                    }else{
                        $message_type="warning";
                        $message="product quantity not added";
                    }
                }

            }
            else{
                $message_type='error';
                $message='your product couldn\'t be added at the moment';
            }

        }
        return response()->json([
            $message_type => true,
            'message'  => $message,
        ], 404);
    }

    public function show($id)
    {
        $user=User::from_api_token();
        $product=Product::where(['id'=>$id])->get();
        if(is_null($product)){
            return response()->json([
                'error' => true,
                'data'  =>$product,
            ], 200);
        }
        return response()->json([
            'error' => false,
            'data'  =>$product,
        ], 200);
    }
    public function update(Request $request, $id)
    {
        $message_type='error';
        $message='Email or Password Invalid!';
        $request->product_id=$id;
        $credentials = $request->only(
            'product_id',
            'name',
            'price',
            'discount',
            'category',
            'subcategory',
            'make',
            'model',
            'year',
            'condition',
            'description',
            'image');
        $validation = Validator::make($credentials,[
            'product_id'=>'required',
            'name'=>'required',
            'price'=>'required',
            'category' => 'required',
            'subcategory' => 'required',
            'make'=>'required',
            'model'=>'required',
            'year'=>'required',
            'condition'=>'required'
        ]);

        if($validation->fails()){
            $errors=$validation->errors();
            foreach ($errors->all() as $message) {
                break;
            }

        }else{
            $wait=ActionController::tryEditProduct($request);
            if($wait){
                $message_type="success";
                $message="product edit";
            }
            else{
                $message_type='error';
                $message='your product couldn\'t be edited at the moment';
            }

        }
        return response()->json([
            $message_type => true,
            'message'  => $message,
        ], 404);
    }
    public function destroy($id)
    {
        $product = Product::where(['id'=>$id])->first();
        if(is_null($product)){
            return response()->json([
                'error' => true,
                'message'  => "Product with id # $id not found",
            ], 404);
        }
        $product->removeImage();
        $product->delete();
        return response()->json([
            'error' => false,
            'message'  => "Product successfully deleted id # $id",
        ], 200);
    }
}

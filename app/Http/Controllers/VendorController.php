<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Product;
use App\User;
use App\Http\Controllers\ActionController;
class VendorController extends Controller
{
    //
    function addProduct(){
        return view('dashboard.vendor.addproduct');
    }
    function products(){
        return view('dashboard.vendor.products');
    }
    function product(Request $request, $product_id){
        $user=User::from_api_token();
        if(is_null($user))
            return redirect()->intended('login?m=please+login')->with('error', 'user not loged in!');
        $product=Product::where(['user_id'=>$user->id,'id'=>$product_id])->first();
        if(is_null($product))
            return redirect()->intended('dashboard/products?m='.urlencode('product with #'.$product_id.' not available on your list'))->with('error', 'user not loged in!');
        if($request->query('action')=='add_quantity' && $request->query('quantity')){
            if(ActionController::tryAddProductQuantity($product_id,$request->query('quantity'))){
                return redirect()->intended('dashboard/product/'.$product_id);
            }
        }
        return view('dashboard.vendor.product')->with(['product'=>$product,'currency'=>Product::currency()]);
    }
    function editProduct($product_id){
        $user=User::from_api_token();
        if(is_null($user))
            return redirect()->intended('login?m=please+login')->with('error', 'user not loged in!');
        $product=Product::where(['user_id'=>$user->id,'id'=>$product_id])->first();
        if(is_null($product))
            return redirect()->intended('dashboard/products?m='.urlencode('product with #'.$product_id.' not available on your list'))->with('error', 'user not loged in!');
        return view('dashboard.vendor.editproduct')->with(['body'=>$product]);
    }
    function doAddProduct(Request $request){
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
        return view('dashboard.vendor.addproduct')->with([$message_type=>$message,'body'=>$credentials]);
    }
    function doEditProduct(Request $request){
        $message_type='error';
        $message='Email or Password Invalid!';
        $credentials = $request->only(
            'product_id','name',
            'price',
            'discount',
            'category',
            'subcategory',
            'make',
            'model',
            'year',
            'condition',
            'description','image');
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
        return view('dashboard.vendor.editproduct')->with([$message_type=>$message,'body'=>$credentials]);
    }
}

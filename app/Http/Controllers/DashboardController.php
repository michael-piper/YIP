<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\User;
use App\Http\Controllers\ActionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
class DashboardController extends Controller
{
    //
    protected $user=null;
    function __construct() {
        // parent::__construct();
        $this->user=Auth::user();

    }
    function isAdmin(){
        if($this->user){
            return ($this->user->type==3);
        }
        return false;
    }
    function isVendor(){
        if($this->user){
           return ($this->user->type==2);
        }
        return false;
    }
    function view($view){
        if($this->isVendor()){
            $view=(string)'dashboard.vendor.'.$view;
        }
        elseif($this->isAdmin()){
            $view=(string)'dashboard.admin.'.$view;
        }else{
            $view=false;
        }

        if ($view && View::exists($view)) {
            return view($view);
        }
        return abort('404','page not found');
    }
    //
    function orders(){
        $this->__construct();
        return $this->view('orders');
    }
    function categories(){
        $this->__construct();
        return $this->view('categories');
    }
    function subCategories(){
        $this->__construct();
        return $this->view('sub_categories');
    }
    function carsMakeAndModel(){
        $this->__construct();
        return $this->view('cars-make-model');
    }
    function products(){
        $this->__construct();
        return $this->view('products');
    }
    function addProduct(){
        $this->__construct();
        if(is_null($this->user))
        return redirect()->intended('login?m=please+login');
        return $this->view('addproduct');
    }
    function editProduct($product_id){
        $this->__construct();
        $user=$this->user;
        if(!Auth::check())
            return redirect()->intended('login?m=please+login')->with('error', 'user not loged in!');
        $product=Product::where(['user_id'=>$user->id,'id'=>$product_id])->first();
        if(is_null($product))
            return redirect()->intended('dashboard/products?m='.urlencode('product with #'.$product_id.' not available on your list'))->with('error', 'user not loged in!');
        return $this->view('editproduct')->with(['body'=>$product]);
    }
    function doAddProduct(Request $request){
        $this->__construct();
        $user=$this->user;
        if(!Auth::check())
        return redirect()->intended('login?m=please+login');
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
        return $this->view('addproduct')->with([$message_type=>$message,'body'=>$credentials]);
    }
    function doEditProduct(Request $request){
        $this->__construct();
        $user=$this->user;
        if(!Auth::check())
        return redirect()->intended('login?m=please+login');
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
        return $this->view('editproduct')->with([$message_type=>$message,'body'=>$credentials]);
    }
}

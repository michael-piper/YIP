<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ActionController;
use App\Product;
use App\Cart;
class ScreenController extends Controller
{
    //

    function home(){
        return view('screen.home');
    }
    function contactus(){
        return view('screen.contactus');
    }
    function cart() {
        return view('screen.cart');
    }
    function dashboard(){
        $user=Auth::user();
        if(!is_null($user) && $user->type==1){
            return redirect()->intended('orders')->with('success', 'user valid!');
        }
        else if(!is_null($user) && $user->type==2){
            return view('dashboard.vendor.main')->with('success', 'user valid!');
        }else if(!is_null($user) && $user->type==3){
            return view('dashboard.admin.main')->with('success', 'user valid!');
        }
        else{
            if(is_null($user))
            return redirect()->intended('login?m=please+login')->with('error', 'user not loged in!');
            return "not autorized";
        }
    }
    function addToCart($cart_id,$quantity) {
        $user=null;
        if(Auth::check()){
            $user=Auth::user();
            $cart = Cart::where(['user_id'=>$user->id,'id'=>$cart_id])->first();  
        }else{
            $cart = Cart::where(['user_id'=>0,'id'=>$cart_id])->first();
        }
        if(is_null($cart)){
            return redirect()->intended('cart?m='.urlencode('item not added to cart'));
        }else{
            $cart->quantity= $cart->quantity + $quantity;
            $cart->save();
        }
        return redirect()->intended('cart?m='.urlencode('item added'));
    }
    function removeFromCart($cart_id,$quantity) {
        $user=null;
        if(Auth::check()){
            $user=Auth::user();
            $cart = Cart::where(['user_id'=>$user->id,'id'=>$cart_id])->first();  
        }else{
            $cart = Cart::where(['user_id'=>0,'id'=>$cart_id])->first();
        }
        if(is_null($cart)){
            return redirect()->intended('cart?m='.urlencode('item not added to cart'));
        }else{
            $cart->quantity= $cart->quantity - $quantity;
            $cart->save();
        }
        return redirect()->intended('cart?m='.urlencode('item removed'));
    }
    function addCartItem($product_id){
        $product=Product::where(['id'=>$product_id,'active'=>1])->first();
        if(Product::isAvailable($product_id,1)){
            if(Auth::check()){
                $user=Auth::user();
                $cart = new Cart;
                $cart->user_id=$user->id;
                $cart->product_id=$product_id;
                $cart->quantity=1;
                $check_cart=Cart::where(['user_id'=>$user->id,'product_id'=>$product_id])->first();
                if(is_null($check_cart)){
                    $cart->save();
                }else{
                    $check_cart->quantity=$check_cart->quantity+1;
                    $check_cart->save();
                }
                return redirect()->intended('cart?m=item+added+to+cart');
            }else{
                $cart = new Cart;
                $cart->user_id=0;
                $cart->product_id=$product_id;
                $cart->quantity=1;
                $check_cart=Cart::where(['user_id'=>0,'product_id'=>$product_id])->first();
                if(is_null($check_cart)){
                    $cart->save();
                    $cart->refresh();
                    if(session()->has('cart')){
                        session()->push('cart',$cart->id);
                    }else{
                        session(['cart'=>[$cart->id]]);
                    }
                }else{
                    $check_cart->quantity=$check_cart->quantity+1;
                    $check_cart->save();
                }
                return redirect()->intended('cart?m=item+added+to+cart+<br>+login+to+save+product+to+account');
            }
            return redirect()->intended('cart?m='.urlencode('unable to add item to cart'));
        }
        if(!is_null($product))
            return redirect()->intended('shop/product-'.$product->id.'/'.$product->name);
        else
            return redirect()->intended('shop/product_not_found');
    }
    function removeCartItem($cart_id) {
        $user=null;
        if(Auth::check()){
            $user=Auth::user();
            $cart = Cart::where(['user_id'=>$user->id,'id'=>$cart_id])->first();  
        }else{
            $cart = Cart::where(['user_id'=>0,'id'=>$cart_id])->first();
        }
        if(is_null($cart)){
            return redirect()->intended('cart?m='.urlencode('item not added to cart'));
        }else{
            if(is_null($user)){
                $session_cart=session('cart');
                if(is_array($session_cart)){
                    foreach($session_cart as $c_key=>$c_val){
                        if($c_val==$cart_id){
                            unset($session_cart[$c_key]);
                            break;
                        }
                    }
                    session(['cart'=>$session_cart]);
                }else{
                    session(['cart'=>[]]);
                }
               
            }
            $cart->delete();
        }
        return redirect()->intended('cart?m='.urlencode('item removed from cart'));
    }
    function order() {
        return view('screen.order');
    }
    function orders() {
        return view('screen.order');
    }
    function shop() {
        return view('screen.shop');
    }
    function shopItem($product_id) {
        return view('screen.shop_item')->with(['product_id'=>$product_id]);
    }
    function login(Request $request){
        $user=Auth::user();
        if(!is_null($user) && $request->query('r'))
        {
            return redirect()->intended($request->query('r'));
        }
        if(!is_null($user) && $user->type==1){
            return redirect()->intended('shop')->with('success', 'user valid!');
        }
        else if(!is_null($user) && $user->type>1){
            return redirect()->intended('dashboard')->with('success', 'user valid!');
        }

        if($request->query('m'))
        return view('screen.login')->with('warning',$request->query('m'));

        return view('screen.login');
    }
    function logout(){
        return redirect('login')->with(Auth::logout());
    }
    function doLogin(Request $request){
        $r=$request->query('r');
        $credentials = ['email'=>$request->input('email'),'password'=>$request->input('password')];

        if (Auth::attempt($credentials)) {
            // Authentication passed...
            $user=Auth::user();
            if(!is_null($user)){
                $session_cart=session('cart');
                if(is_array($session_cart)){
                    foreach($session_cart as $cart_id){
                        $cart=Cart::where(['user_id'=>0,'id'=>$cart_id])->first();
                        if(!is_null($cart)){
                            $check_cart=Cart::where(['user_id'=>$user->id,'product_id'=>$cart->product_id])->first();
                            if(is_null($check_cart)){
                                $cart->user_id=$user->id;
                                $cart->save();
                            }else{
                                $check_cart->quantity=$check_cart->quantity+$cart->quantity;
                                $check_cart->save();
                                $cart->delete();
                            }
                           
                        }
                    }
                    session(['cart'=>[]]);
                }else{
                    session(['cart'=>[]]);
                }
            }
            if(!is_null($user) && isset($r))
            {
                return redirect()->intended($r);
            }
            if(!is_null($user) && $user->type==1){
                return redirect()->intended('shop')->with('success', 'user valid!');
            }
            else if(!is_null($user) && $user->type>1){
                return redirect()->intended('dashboard')->with('success', 'user valid!');
            }
        }else{

        }
        return view('screen.login')->with('error', 'Email or Password Invalid!');
    }
    function signup(){
        return view('screen.signup');
    }
    function doSignup(Request $request){
        $message_type='error';
        $message='Email or Password Invalid!';
        $credentials = $request->only('name','email', 'phone', 'address', 'password','confirm_password');
        $validation = Validator::make($credentials,[
            'name'=>'required',
            'email'=>'required|unique:users,email',
            'phone'=>'required|unique:users,phone',
            'address' => 'required',
            'password' => 'required',
            'confirm_password'=>'required'
        ]);

        if($validation->fails()){
            $errors=$validation->errors();
            foreach ($errors->all() as $message) {
                break;
            }

        }else if($credentials['password']!=$credentials['confirm_password']){
            $message_type='error';
            $message="Passowrd and confirm password not the same!";
        }else{
            $wait=ActionController::tryRegisterCustomer($request);
            if($wait){
                $message_type="success";
                $message="your account have been created";
            }
            else{
                $message_type='error';
                $message='your account couldn\'t be created at the moment';
            }

        }
        return view('screen.signup')->with([$message_type=>$message,'body'=>$credentials]);
    }
    function signupVendor(Request $request){
        $message_type='error';
        $message='Email or Password Invalid!';
        $credentials = $request->only('name', 'contact_name', 'email', 'phone', 'address', 'state', 'id_card_type', 'id_card_number', 'password', 'confirm_password');
        $validation = Validator::make($credentials,[
            'name'=>'required',
            'contact_name'=>'required',
            'email'=>'required|unique:users,email',
            'phone'=>'required|unique:users,phone',
            'address' => 'required',
            'state'=>'required',
            'id_card_type'=>'required',
            'id_card_number'=>'required',
            'password' => 'required',
            'confirm_password'=>'required'
        ]);

        if($validation->fails()){
            $errors=$validation->errors();
            foreach ($errors->all() as $message) {
                break;
            }

        }else if($credentials['password']!=$credentials['confirm_password']){
            $message_type='error';
            $message="Passowrd and confirm password not the same!";
        }else{
            $wait=ActionController::tryRegisterVendor($request);
            if($wait){
                $message_type="success";
                $message="your account have been created";
            }
            else{
                $message_type='error';
                $message='your account couldn\'t be created at the moment';
            }

        }
        return view('screen.signup_vendor')->with([$message_type=>$message,'body'=>$credentials]);
    }
    function doSignupVendor(){
        return view('screen.signup_vendor');
    }
    function forgetPassword(){
        return view('screen.forgetpassword');
    }
    function doForgetPassword(){
        return view('screen.forgetpassword');
    }

}

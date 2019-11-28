<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\ActionController;
use App\Product;
use App\Cart;
use App\Order;
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
    function cartCheckout(Request $request){
        $user=Auth::user();
        $name=$request->input('shipping_name');
        $phone=$request->input('shipping_phone');
        $email=$request->input('shipping_email');
        $state=$request->input('shipping_state');
        $address=$request->input('shipping_address');
        $shipping_fee=$request->input('shipping_fee');
        if($request->query('from')=="ajax"){
            if(is_null($user))
            return response()->json(['error'=>true,'message'=>'user not logedIn']);
            $tracking_id='trk-'.time().'-'.mt_rand(10000,99999);

            if($request->input('id') != null){
                $order= Order::where(['id'=>$request->input('id')])->first();
                if(is_null($order)){
                    return response()->json(['error'=>true,'message'=>'order id not found']);
                }
                $order->tracking_id=$tracking_id;
                $order->save();
                $total=$order->total_price+$order->shipping_fee;
                return response()->json(['error'=>false,'data'=>['total_price'=>$total,'tracking_id'=>$tracking_id,'shipping'=>$order->contact()]]);
            }
            elseif(is_null($name) || is_null($phone) || is_null($address) || is_null($state)){
                return response()->json(['error'=>true,'message'=>'Shipping address, state, phone, name can\'t be empty']);
            }

            $carts = Cart::where(['user_id'=>$user->id])->get();
            $total=0;
            foreach($carts as $cart){
                $product=Product::where(['id'=>$cart->product_id])->first();
                $new_order= new Order;
                $new_order->contact($request->input(),true);
                $new_order->user_id=$user->id;
                $new_order->product_id=$cart->product_id;
                $new_order->tracking_id=$tracking_id;
                $new_order->quantity=$cart->quantity;
                $new_order->price=$product->priceWithCommission();
                $new_order->total_price=$new_order->price * $new_order->quantity;
                if($shipping_fee){
                    $new_order->shipping_fee=(int) $shipping_fee;
                }else{
                    $new_order->shipping_fee= 5 * $new_order->quantity;
                }
                $new_order->order_status=1;
                $new_order->payment_status=1;
                $total=$total+$new_order->total_price+$new_order->shipping_fee;
                $new_order->save();
                $cart->delete();
            }
            return response()->json(['error'=>false,'data'=>['total_price'=>$total,'tracking_id'=>$tracking_id,'shipping'=>$request->input()]]);
        }else{
            if(is_null($user))
            return redirect()->intended('login?m=please+login');
            return redirect()->intended('orders');
        }

    }
    function verifyPayment(Request $request){
        $user=Auth::user();
        $reference=$request->query('reference');
        $success=false;
        if($request->query('from')=="ajax"){
            if(is_null($user))
            return response()->json(['error'=>true,'message'=>'user not logedIn']);

            if( is_null($reference)){
                return response()->json(['error'=>true,'message'=>'reference cannot be null']);
            }
            $orders=Order::where(['user_id'=>$user->id,'tracking_id'=>$reference])->get();
            $total=0;
            foreach($orders as $order){
                $total=$total+ (int)$order->total_price + (int)$order->shipping_fee;
            }
            $total=(int)($total."00");
            $result = array();
            //The parameter after verify/ is the transaction reference to be verified
            $url = 'https://api.paystack.co/transaction/verify/'.$reference;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt(
            $ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer sk_test_17b11b55e732817698903279c2a92ff2331d853e']
            );
            $request = curl_exec($ch);
            curl_close($ch);

            if ($request) {
                $result = json_decode($request, true);
                // print_r($result);
                if($result){
                    if(isset($result['data'])){
                        //something came in
                        if($result['data']['status'] == 'success' && $result['data']['amount']== $total){
                            $success=true;
                            foreach($orders as $order){
                                $order->payment_status=2;
                                $order->save();
                            }
                        }else{
                            foreach($orders as $order){
                                $order->payment_status=1;
                                $order->save();
                            }
                            $success=false;
                        }
                    }else{
                        foreach($orders as $order){
                            $order->payment_status=0;
                            $order->save();
                        }
                        $success=false;
                    }

                }else{
                    $success=false;
                }
            }else{
                $success=false;
            }
            if($success){
                return response()->json(['error'=>false,'message'=>'Payment verified']);
            }else{
                return response()->json(['error'=>true,'message'=>'Payment couldn\'t be verified please try again','data'=>$result,'total'=> $total]);
            }
        }else{
            if(is_null($user))
            return redirect()->intended('login?m=please+login');

            return redirect()->intended('orders');
        }
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
            return redirect()->intended('login?m=please+login');
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
        if(Auth::check())
        return view('screen.order');
        return redirect()->intended('login?r=/order&m='.urlencode('please login to view orders'));

    }
    function orders() {
        if(Auth::check())
        return view('screen.order');
        return  redirect()->intended('login?r=/orders&m='.urlencode('please login to view orders'));

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
                return redirect()->intended('login?m='.urlencode($message));
            }
            else{
                $message_type='error';
                $message='your account couldn\'t be created at the moment';
            }

        }
        return view('screen.signup')->with([$message_type=>$message,'body'=>$credentials]);
    }
    function doSignupVendor(Request $request){
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
                return redirect()->intended('login?m='.urlencode($message));
            }
            else{
                $message_type='error';
                $message='your account couldn\'t be created at the moment';
            }

        }
        return view('screen.signup_vendor')->with([$message_type=>$message,'body'=>$credentials]);
    }
    function signupVendor(){
        return view('screen.signup_vendor');
    }
    function forgetPassword(){
        return view('screen.forgetpassword');
    }
    function doForgetPassword(){
        return view('screen.forgetpassword');
    }

}

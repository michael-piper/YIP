<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\UserDetail;
use App\ProductAvailable;
use App\Product;
use App\OTP;
use Carbon\Carbon;
use Mail;
class ActionController extends Controller
{
    static function sendMail($msg=[],$template="general"){
      $msg=(array)$msg;
        Mail::send('mail.'.$template, $msg, function($message) use($msg){
            $message->from('no-reply@motopartsarena.com', 'Motoparts Arena');
            $message->SMTPDebug = 4;
            $message->to($msg['email']);
            $message->subject($msg['subject']);
            //return response()->json(["succeess"=>'An Email has been sent to your account. Pls check to proceed']);
        });
    }
    static function sendSMS($msg=[]){
        $msg=(object)$msg;
        if(isset($msg->phone) && isset($msg->body)){
            $url = "http://www.quickbuysms.com/index.php?option=com_spc&comm=spc_api&username=primealert&password=primealert&sender=MOTOPARTSARENA&recipient=".$msg->phone."&message=".urlencode($msg->body);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $data = curl_exec($ch);
            curl_close($ch);
            return $data;
        }else{
            return false;
        }
    }
    static function sendOTP($map){

        if($map['phone']){
            $data=[];
            $data['body']='Your otp is '.$map['otp'];
            $data['phone']=$map['phone'];
            ActionController::sendSMS($data);
        }
        if($map['email']){
            $data=[];
            $data['body']='Your otp is '.$map['otp'];
            $data['email']=$map['email'];
            $data['subject']='Reset Password OTP';
            ActionController::sendMail($data);
        }
        return true;
    }
    static function tryRequestOTP($user_id){
        $user=User::where('id',$user_id)->first();
        if(is_null($user))return false;
        $data=[];
        $data['phone']=$user->phone;
        $data['email']=$user->email;
        $data['otp']=mt_rand(000000,999999);
        $otp= OTP::where(['otp'=>$data['otp'],'user_id'=>$user_id,'active'=>1])->first();
        if(!is_null($otp)){
            return ActionController::tryRequestOTP($user_id);
        }
        $otp= new OTP;
        $otp->user_id=$user_id;
        $otp->otp=$data['otp'];
        $otp->save();
        ActionController::sendOTP($data);
        return true;
    }
    static function tryVerifyOTP($user_id,$otp){
        $user=User::where('id',$user_id)->first();
        if(is_null($user) || is_null($otp) || $otp=='')return false;
        $otp= OTP::where(['otp'=>$otp,'user_id'=>$user_id,'active'=>1])->first();
        if(is_null($otp)){
            return false;
        }
        $current_date= Carbon::now();
        $created_date=new Carbon($otp->created_at);
        if($current_date->diffInMinutes($created_date)>10){
            $otp->active=0;

            $otp->save();
            return false;
        }
        $user->verify_token=$user->id+'-'+md5(mt_rand(3000003111,9999999999)*time());
        $user->save();
        return $user->verify_token;
    }
    public function tryResetPassword($key,$password){
        if(is_null($key))return false;
        $user=User::where('verify_token',$key)->first();
        if(is_null($user) || is_null($password) || $password=='')return false;
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return true;
    }
    public function tryUpdatePassword(Request $request){
        $user = User::from_api_token();

        if(is_null($user)){
            return ['error'=>true,'message'=>'user seession not recogized'];
        }
        if ($request->input('password') != $request->input('password1')) {
            return ['error'=>true,'message'=> 'The new passwords provided does not match. Pls try again'];
        }

        if (Hash::check($request->input('old_password'), $user->password)) {
            $user->password = bcrypt($request->input('password'));
            $user->save();
            return ['success'=>true, 'message'=>'Your profile has been successfully updated. Kindly check your email to proceed'];
        }else{
            return ['error'=>true, 'message'=>'You have provided a wrong password. Pls try again'];
        }
    }
    public function tryActivateUser($token,$id){
        $user = User::where(["token"=> $token,'id'=>$id])->first();
        $user->status = "Activated";
        if($user->save()){
            Auth::loginUsingId($user->id);
            return ['success'=>true,'message'=>'user account activated'];
        }else{
            return ['error'=>true,'message'=>'user account couldn\'t be activated'];
        }
    }
    static function tryRegisterCustomer($request){
        $newuser= new User();
        $newuser->display_name=$request->name;
        $newuser->email=$request->email;
        $newuser->phone=$request->phone;
        $newuser->type=1;
        $newuser->display_type="Customer";
        $newuser->api_token=time().Str::random(22);
        $newuser->password=bcrypt($request->password);
        if($newuser->save() && $newuser->refresh()){
            $addons=(object)["address"=>$request->address];
            $contact=(object)[];
            $newuser_detail=new UserDetail();
            $newuser_detail->user_id=$newuser->id;
            $newuser_detail->addons=json_encode($addons);
            $newuser_detail->contact=json_encode($contact);
            $newuser_detail->save();
            return true;
        }
        return false;
    }
    static function tryRegisterVendor($request){
        $newuser= new User();
        $newuser->display_name=$request->name;
        $newuser->email=$request->email;
        $newuser->phone=$request->phone;
        $newuser->type=2;
        $newuser->display_type="Vendor";
        $newuser->api_token=time().Str::random(22);
        $newuser->password=bcrypt($request->password);
        if($newuser->save() && $newuser->refresh()){
            $addons=(object)["address"=>$request->address,"contact_person"=>$request->contact_name,'state'=>$request->state,'id_card_type'=>$request->id_card_type,'id_card_number'=>$request->id_card_number];
            $contact=(object)[];
            $newuser_detail=new UserDetail();
            $newuser_detail->user_id=$newuser->id;
            $newuser_detail->addons=json_encode($addons);
            $newuser_detail->contact=json_encode($contact);
            $newuser_detail->save();
            return true;
        }
        return false;
    }
    static function tryAddProduct($request){
        $user=User::from_api_token();
        if(!$user) return false;
        $product= new Product();
        $product->name=$request->name;
        $product->price=$request->price;
        $product->commission=Product::cal_commission((int)$request->price);
        $product->available=0;
        $product->category_id=$request->category;
        $product->sub_category_id=$request->subcategory;
        $product->user_id=$user->id;
        $product->display_image=null;
        $product->condition=$request->condition;
        $product->description=$request->description;
        $year=$request->input("year");
        if($request->input("discount")){
            $product->addons(['discount'=>$request->input("discount")],true);
        }else{
            $product->addons(['discount'=>0],true);
        }
        if($request->hasFile("image")){
            $image = $request->file("image");
            $product->defaultImage($image);
        }
        if(is_array($year)){
            $product->year=implode(';',$year);
        }else{
            $product->year=$year;
        }
        $product->make=$request->make;
        $product->model=$request->model;
        if($product->save() && $product->refresh()){
            return $product;
        }
        return false;
    }
    static function tryEditProduct($request){
        $user=User::from_api_token();
        if(is_null($user)) return false;
        $product = Product::where('id',$request->input('product_id'))->first();
        if(is_null($product)) return false;
        $product->name=$request->name;
        $product->price=$request->price;
        $product->commission=Product::cal_commission((int)$request->price);
        $product->category_id=$request->category;
        $product->sub_category_id=$request->subcategory;
        $product->condition=$request->condition;
        $product->description=$request->description;
        $year=$request->input("year");
        if($request->input("discount")){
            $product->addons(['discount'=>$request->input("discount")]);
        }else{
            $product->addons(['discount'=>0]);
        }
        if($request->hasFile("image")){
            $image = $request->file("image");
            $product->defaultImage($image);
        }
        if(is_array($year)){
            $product->year=implode(';',$year);
        }else{
            $product->year=$year;
        }
        $product->make=$request->make;
        $product->model=$request->model;
        if($product->save() && $product->refresh()){
            return $product;
        }
        return false;
    }
    static function tryAddProductQuantity($product_id,$quantity){
        $quan=new ProductAvailable();
        $quan->product_id=$product_id;
        $quan->quantity=$quantity;
        if($quan->save()){
            $product_availables=ProductAvailable::where('product_id',$product_id)->get();
            $available=0;
            if(!is_null($product_availables)){
                foreach($product_availables as $avail){
                    $available=$available+ $avail->quantity;
                }
            }
            $product=Product::where('id',$product_id)->first();
            $product->available=$available;
            $product->save();
            return true;
        }
        return false;
    }
}

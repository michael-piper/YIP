<?php

namespace App\Http\Controllers\APIv1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ActionController;
use App\OTP;
use App\User;
class OTPController extends Controller
{
    //
    public function index(Request $request)
    {
        return response()->json(['error'=>false,'data'=>[]]);
    }
    public function store(Request $request)
    {
        $username=$request->input('username');
        if($username==null){
            return response()->json([
                'error' => true,
                'message'  =>'no input for username',
            ], 200);
        }
        $res= User::where(['phone'=>$username])->orWhere(['email'=>$username])->first();
        if(is_null($res) ){
            return response()->json([
                'error' => true,
                'message'  =>'user doesn\'t exist',
            ], 200);
        }
        $otp=new OTP;
        $otp->user_id=$res->id;
        $otp->otp=mt_rand(100000,999999);
        $otp->save();
        $msg='your new OTP for Motoparts Arena is '.$otp->otp;
        ActionController::sendSMS(['phone'=>$res->phone,'body'=>$msg]);
        ActionController::sendMail(['email'=>$res->email,'subject'=>'OTP FROM Motoparts Arena','body'=>$msg]);
        return response()->json([
            'error' => false,
            'message'  =>'OTP has been sent to '.$res->phone.' and your email:'.$res->email
        ], 200);
    }
    public function create($username){
        $res= User::where(['phone'=>$username])->orWhere(['email'=>$username])->first();
        if(is_null($res) ){
            return response()->json([
                'error' => true,
                'message'  =>'user doesn\'t exist',
            ], 200);
        }
        $otp=new OTP;
        $otp->user_id=$res->id;
        $otp->otp=mt_rand(100000,999999);
        $otp->save();
        $msg='your new OTP for Motoparts Arena is '.$otp->otp;
        ActionController::sendSMS(['phone'=>$res->phone,'body'=>$msg]);
        ActionController::sendMail(['email'=>$res->email,'subject'=>'OTP FROM Motoparts Arena','body'=>$msg]);
        return response()->json([
            'error' => false,
            'message'  =>'OTP has been sent to '.$res->phone.' and your email:'.$res->email
        ], 200);

    }
    public function confirm(Request $request, $username){
        $res= User::where(['phone'=>$username])->orWhere(['email'=>$username])->first();
        if(is_null($res) || is_null($username) ){
            return response()->json([
                'error' => true,
                'message'  =>'user doesn\'t exist',
            ], 200);
        }
        $otp= OTP::where(['user_id'=>$res->id,'otp'=>$request->query('otp')])->first();
        if(is_null($otp)){
            return response()->json([
                'error' => true,
                'message'  =>'OTP not valid',
            ], 200);
        }
        return response()->json([
            'error' => false,
            'message'=>'OTP valid',
            'data'  =>$otp,
        ], 200);
    }
    public function show(Request $request, $r_otp){
        $res= User::where(['phone'=>$request->query('username')])->orWhere(['email'=>$request->query('username')])->first();
        if(is_null($res) || is_null($request->query('username')) ){
            return response()->json([
                'error' => true,
                'message'  =>'user doesn\'t exist',
            ], 200);
        }
        $otp= OTP::where(['user_id'=>$res->id,'otp'=>$r_otp])->first();
        if(is_null($otp)){
            return response()->json([
                'error' => true,
                'message'  =>'OTP not valid',
            ], 200);
        }
        return response()->json([
            'error' => false,
            'message'=>'OTP valid',
            'data'  =>$otp,
        ], 200);
    }
}

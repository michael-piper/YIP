<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\UserDetail;
class AccountContactController extends Controller
{
    //
    function index(){
        $user=User::from_api_token();
        if(is_null($user)){
            return response()->json(['error'=>true,'message'=>'No active session']);
        }
        $userdetails=UserDetail::where(['user_id'=>$user->id])->first();
        return response()->json(['error'=>false,'data'=>$userdetails->contact()]);
    }
    function store(Request $request){
        $contact=$request->all();
        $user=User::from_api_token();
        if(is_null($user)){
            return response()->json(['error'=>true,'message'=>'No active session']);
        }
        $userdetails=UserDetail::where(['user_id'=>$user->id])->first();
        $contacts=$userdetails->contact();
        $contacts[]=$contact;
        $userdetails->contact($contacts,true);
        $userdetails->save();
        return response()->json(['error'=>false,'message'=>'Contact created','data'=>$contacts]);
    }
    public function show($id)
    {
        $user=User::from_api_token();
        if(is_null($user)){
            return response()->json(['error'=>true,'message'=>'No active session']);
        }
        $userdetails=UserDetail::where(['user_id'=>$user->id])->first();
        $contacts=$userdetails->contact();
        return response()->json(['error'=>false,'data'=>$contacts[$id]]);
    }
    function update(Request $request,$id){
        $contact=$request->all();
        $user=User::from_api_token();
        if(is_null($user)){
            return response()->json(['error'=>true,'message'=>'No active session']);
        }
        $userdetails=UserDetail::where(['user_id'=>$user->id])->first();
        $contacts=$userdetails->contact();
        $contacts[$id]=$contact;
        $userdetails->contact($contacts,true);
        $userdetails->save();
        return response()->json(['error'=>false,'message'=>'contact updated']);
    }
    function destroy($id){
        $user=User::from_api_token();
        if(is_null($user)){
            return response()->json(['error'=>true,'message'=>'No active session']);
        }
        $userdetails=UserDetail::where(['user_id'=>$user->id])->first();
        $contacts=$userdetails->contact();
        if(is_array($contacts))
        unset($contacts[$id]);
        $newdata=[];
        foreach ($contacts as $value) {
            # code...
            $newdata[]=$value;
        }
        $contacts=$newdata;
        $userdetails->contact($contacts,true);
        $userdetails->save();
        return response()->json(['error'=>false,'message'=>'contact deleted']);   
    }
}

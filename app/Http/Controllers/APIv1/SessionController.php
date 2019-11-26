<?php

namespace App\Http\Controllers\APIv1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\User;
use App\UserDetail;
use App\SessionMap;
class SessionController extends Controller
{
    //
    public function index()
    {
        $user=User::from_api_token();

        /*
         *
         * **
         *
         */
        if(is_null($user))return response()->json(['error'=>true,'user'=>$user,'message'=>'no active session']);
        $session=SessionMap::where(['user_id'=>$user->id])->get();
        return response()->json([
            'error' => false,
            'data'  => $session,
        ], 200);
    }
    public function store(Request $request)
    {
        $username=$request->input('username');
        $password=$request->input('password');
        if($username==null && $password==null){
            return response()->json([
                'error' => true,
                'message'  =>'no input for username and password',
            ], 200);
        }
        $res= User::where(['phone'=>$username,'active'=>1])->orWhere(['email'=>$username])->where(['active'=>1])->first();
        if(is_null($res) || !Hash::check($password,$res->password)){
            return response()->json([
                'error' => true,
                'message'  =>'password or username incorrect',
            ], 200);
        }
        $headers=getallheaders();
        $session=new SessionMap;
        $session->user_id=$res->id;
        $session->token=mt_rand(000,999).time().mt_rand(00,99);
        $session->key=Str::random(22);
        $session->user_agent=$headers['User-Agent'] ?? '';
        $session->save();
        $session->refresh();
        $res->session=$session;
        $res->Authorization='Bearer '.base64_encode($session->token.' '.$session->key);
        return response()->json([
            'success' => true,
            'data'  =>$res
        ], 200);
    }
    public function show($id)
    {
        $user=User::from_api_token();
        if(is_null($user))return response()->json(['error'=>true,'message'=>'no active session']);
        $session=SessionMap::where(['user_id'=>$user->id,'id'=>$id])->first();
        if(is_null($session)){
            return response()->json([
                'error' => true,
                'data'  =>$session,
            ], 200);
        }
        return response()->json([
            'error' => false,
            'data'  =>$session,
        ], 200);
    }
    public function update(Request $request, $id)
    {
        $user=User::from_api_token();
        if(is_null($user))return response()->json(['error'=>true,'message'=>'no active session']);
        $headers=getallheaders();
        $session = SessionMap::where(['user_id'=>$user->id,'id'=>$id])->first();
        if(is_null($session)){
            return response()->json([
                'error' => true,
                'message'  => "Session with id # $id not found",
            ], 404);
        }
        $session->user_agent=$headers['User-Agent'] ?? '';
        $session->save();
        return response()->json([
            'error' => false,
            'message'  => "Session successfully updated id # $id",
        ], 200);
    }
    public function destroy($id)
    {
        $user=User::from_api_token();
        if(is_null($user))return response()->json(['error'=>true,'message'=>'no active session']);
        try{
            $session = SessionMap::where(['user_id'=>$user->id,'id'=>(int)$id])->first();

        }catch(Exception $e){
            $data=explode(' ',base64_decode($id),1);

            $token=$data[0]??null;
            $key=$data[1]??null;
            $session = SessionMap::where(['user_id'=>$user->id,'key'=>$key,'token'=>$token])->first();
        }
        if(is_null($session)){
            return response()->json([
                'error' => true,
                'message'  => "Session with id # $id not found",
            ], 404);
        }
        $session->delete();
        return response()->json([
            'error' => false,
            'message'  => "Session successfully deleted id # $id",
        ], 200);
    }
}

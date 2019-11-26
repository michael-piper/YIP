<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\SessionMap;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function carts(){
        return $this->hasMany('App\Cart');
    }
    public function cart(){
        return $this->hasOne('App\Cart');
    }
    public function orders(){
        return $this->hasMany('App\Order');
    }
    public function order(){
        return $this->hasOne('App\Order');
    }
    public static function verify_api_token(){
        $headers=getallheaders ();
        $session=$headers['Authorization'] ?? null;
        $session_data=explode(' ',$session);
        $api_token= $hearders['X-Api-Token'] ?? null;
        if(isset($session_data[0]) && isset($session_data[1])){
            $session_data[0]=trim($session_data[0]);
            if($session_data[0]=="Basic"){
                $user=base64_decode($session_data[1]);
                $user=explode(':',$user,2);
                if(isset($user[0])&& isset($user[1])){
                    $res = User::where(['phone'=>$user[0],'active'=>1])->orWhere(['email'=>$user[0]])->where(['active'=>1])->first();
                   if(!is_null($res) && Hash::check($user[1],$res->password)){
                    Auth::loginUsingId($data->id);
                    return true;
                   }else{
                    return false;
                   }
                }
                return false;
            }else if($session_data[0]=="Bearer"){
                $user=base64_decode($session_data[1]);
                $user=explode(' ',$user,2);
                if(isset($user[0]) && isset($user[1])){
                   $res = SessionMap::where(['token'=>$user[0],'key'=>$user[1]])->first();
                   if(!is_null($res)){
                    Auth::loginUsingId($res->user_id);
                    return true;
                   }else{
                    return false;
                   }
                }
                return false;
            }
            return false;
        }
        else if($api_token){
            $data=User::where(['api_token' =>$api_token])->first();
            if($data){
                Auth::loginUsingId($data->id);
                return true;
            }
        }
        return false;
    }
    public static function from_api_token(){
        if(Auth::check()) return Auth::user();
        $headers=getallheaders ();
        $session=$headers['Authorization'] ?? null;
        $session_data=explode(' ',$session);
        $api_token= $hearders['X-Api-Token'] ?? null;
        if(isset($session_data[0]) && isset($session_data[1])){
            $session_data[0]=trim($session_data[0]);
            if($session_data[0]=="Basic"){
                $user=base64_decode($session_data[1]);
                $user=explode(':',$user,2);
                if(isset($user[0])&& isset($user[1])){
                   $res = User::where(['phone'=>$user[0],'active'=>1])->orWhere(['email'=>$user[0]])->where(['active'=>1])->first();
                   if(!is_null($res) && Hash::check($user[1],$res->password)){
                    return $res;
                   }else{
                    return null;
                   }
                }
                return null;
            }else if($session_data[0]=="Bearer"){
                $user=base64_decode($session_data[1]);
                $user=explode(' ',$user,2);
                if(isset($user[0]) && isset($user[1])){
                   $res= SessionMap::where(['token'=>$user[0],'key'=>$user[1]])->first();
                   if(!is_null($res)){
                    return User::where(['id' =>$res->user_id])->first();
                   }else{
                    return null;
                   }
                }
                return null;
            }
            return null;
        }
        else if($api_token){
            $data=User::where(['api_token' =>$api_token])->first();
            if($data){
                return $data;
            }else{
              if(Auth::check()) return Auth::user();
            }
        }
        else if(Auth::check()) return Auth::user();
        return null;
    }
}

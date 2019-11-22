<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
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
        $api_token= getallheaders ()['X-Api-Token'] ?? '';
        if($api_token){
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
        $api_token= getallheaders ()['X-Api-Token'] ?? '';
        if($api_token){
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

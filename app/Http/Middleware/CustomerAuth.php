<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;
class CustomerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user=Auth::user();
        }else{
            return abort("401", "User not a Customer");
        }
        if (!is_null($user) && $user->type == 1) {
            return $next($request);
        }
        return abort("401", "User not a Customer");
    }
}

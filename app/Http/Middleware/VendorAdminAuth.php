<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;
class VendorAdminAuth
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
            return abort("401", "User not valid");
        }
        if (!is_null($user) && $user->type > 1) {
            return $next($request);
        }
        // return $next(new \Illuminate\Http\Request);
        return abort("401", "user not an Admin or Vendor");
    }
}

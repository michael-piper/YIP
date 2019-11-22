<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
class ApiTokenAuth
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
        if (!User::verify_api_token()) {
            return abort("401", "user not authorized");
        }else{
            return $next($request);
        }
    }
    public function update(Request $request)
    {
        $token = Str::random(60);
        if (Auth::check()) {
            $request->user()->forceFill([
                'api_token' => hash('sha256', $token),
            ])->save();

            return ['token' => $token];
        }
    }
}

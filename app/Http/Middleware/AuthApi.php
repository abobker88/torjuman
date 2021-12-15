<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
    * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        if($token){
        $user = User::where('api_token', $token)->first();
        if ($user) {
           
            auth()->login($user);
            return $next($request);
        } else {
        return response([
            'message' => 'invalid email or password'
        ], 403);
    }
    } else {
        return response([
            'message' => 'invalid email or password'
        ], 403);
    }
    }
}

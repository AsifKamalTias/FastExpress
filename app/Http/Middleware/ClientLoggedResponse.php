<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ClientToken;

class ClientLoggedResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $tk = $request->header("Authorization");
        if($tk !=null){
            $token = Token::where('token',$tk)
                     ->whereNull('expires_at')
                     ->first();
            if($token){
                return $next($request);
            }
            return response()->json(["msg"=>"Supplied Token is invalid or expired"], 401);
        }
        return response()->json(["msg"=>"Not token supplied"], 401);
    }
}

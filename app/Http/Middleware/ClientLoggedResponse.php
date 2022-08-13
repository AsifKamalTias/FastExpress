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
        $key=$request->header("Authorization");
        if ($key)
        {
            $token=ClientToken::where('token',$key)->whereNUll('expires_at')->first();
            if($token)
            {
                return $next($request);             
            }
            return response()->json(["msg"=>"Invalid token"], 401);
        }
        return response()->json(["msg"=>"Credentials not found!"], 401);
    }
}

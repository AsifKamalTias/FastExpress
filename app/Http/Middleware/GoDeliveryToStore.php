<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GoDeliveryToStore
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
        if(session()->has('deliveryFromLat') && session()->has('deliveryFromLon'))
        {
            return $next($request);
        }
        else
        {
            return redirect()->route('delivery.from');
        }
    }
}

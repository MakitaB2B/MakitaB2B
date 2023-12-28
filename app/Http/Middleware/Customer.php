<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class Customer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('customer')->check()){
            $status=Auth::guard('customer')->user()->status;
            if($status==0){
                return redirect()->route('cxlogin')->with('error','Access has been revoked!');
            }
        }elseif(!Auth::guard('customer')->check()){
            return redirect()->route('cxlogin')->with('error','Access Denied!');
        }
        return $next($request);
    }
}

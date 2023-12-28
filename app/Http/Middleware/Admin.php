<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::guard('admin')->check()){
            $status=Auth::guard('admin')->user()->status;
            if($status==0){
                return redirect()->route('adminlogin')->with('error','Access has been revoked!');
            }
        }elseif(!Auth::guard('admin')->check()){
            return redirect()->route('adminlogin')->with('error','Access Denied!');
        }
        return $next($request);
    }
}

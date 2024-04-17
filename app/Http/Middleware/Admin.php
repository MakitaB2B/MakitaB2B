<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Admin\AdminLogin;
use Auth;
use Cache;

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
            $hasPasswordSet=Auth::guard('admin')->user()->password_set;
            if($status==0){
                return redirect()->route('adminlogin')->with('error','Access has been revoked!');
            }elseif($hasPasswordSet==0){
                return redirect('admin/register');
            }elseif($status==1){
                $adminId=Auth::guard('admin')->user()->id;
                $expireAt= now()->addMinutes(1);
                Cache::put('emp-login-activity'.$adminId,true,$expireAt);
                AdminLogin::where('id',$adminId)->update(['last_activity'=>now()]);
            }
        }elseif(!Auth::guard('admin')->check()){
            return redirect()->route('adminlogin')->with('error','Access Denied!');
        }
        return $next($request);
    }
}

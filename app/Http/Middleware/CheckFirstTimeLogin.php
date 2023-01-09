<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckFirstTimeLogin
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
        if (Auth::user()->must_change_password == 0)
        {
            return redirect()->route('force-change-password');
        }
        //if(Auth::user()->hrms_nda_at === null)
        //{
        //    return redirect()->route('check.nda');
        //}
        return $next($request);
    }
}

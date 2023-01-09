<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // if (Auth::guard($guard)->check()) {
        //     return redirect('/dashboard');
        // }

        // return $next($request);

        if(Auth::guard($guard)->check()){
            // if (Auth::viaRemember()) {
            //     if (auth()->user()->hasAnyRole(['User']) ) {
            //         request()->session()->put('validateRole', 'User');
            //         // dd(request()->session()->get('validateRole'));
            //         return redirect()->route('user.home');
            //     }
            //     elseif (!auth()->user()->hasAnyRole(['User']) ) {
            //         request()->session()->put('validateRole', 'Admin');
            //         return redirect()->route('dashboard');
            //     }
            // }

            if ( $request->user()->hasAnyRole(['User']) ) {
                return redirect('/user/dashboard');
            }
            if ( $request->user()->hasAnyRole(['Admin', 'Super Admin']) ) {
                return redirect('/dashboard');
            }


        }
        return $next($request);
    }
}

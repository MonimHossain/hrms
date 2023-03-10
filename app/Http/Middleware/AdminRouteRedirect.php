<?php

namespace App\Http\Middleware;

use Closure;

class AdminRouteRedirect
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
        if(request()->session()->get('validateRole') == 'Admin'){
            return $next($request);
        }else{
            return redirect()->route('user.dashboard');
        }

    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class UserRouteRedirect
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
            return redirect()->route('dashboard');
        }else{
            return $next($request);
        }
    }
}

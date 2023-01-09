<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class EmploymentStatusCheck
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
        if (Auth::user()->status != 1)
        {
            Auth::logout();
            toastError('Your id is suspended or inactive.');
            return redirect()->route('login');
        }
        return $next($request);
    }
}

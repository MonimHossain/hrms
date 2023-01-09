<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckDefaultDivision
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
        if (Auth::user()->default_division_id == null && Auth::user()->default_center_id == null && session()->get('validateRole') != 'User')
        {
            return redirect()->route('settings.manage.default.division');
        }
        return $next($request);
    }
}

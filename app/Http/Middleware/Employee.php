<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class Employee
 * @package App\Http\Middleware
 */
class Employee
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $destinations = config('custom.roles_destinations');
        if (!Auth::check()){

            return redirect()->route('login');
        }

        if(Auth::user()->type !== 'employee' ){

            return redirect()->route($destinations[Auth::user()->type]);
        }

        return $next($request);
    }
}

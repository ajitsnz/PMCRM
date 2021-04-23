<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     *
     * @param  Closure  $next
     *
     * @param  string|null  $guard
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            if (Auth::user()->hasRole(['client'])) {
                return \Redirect::to(RouteServiceProvider::CLIENT_HOME);
            } else {
                return \Redirect::to(RouteServiceProvider::ADMIN_HOME);
            }
        }

        return $next($request);
    }
}

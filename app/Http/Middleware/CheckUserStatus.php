<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Flash;
use Illuminate\Http\Request;

/**
 * Class CheckUserStatus
 */
class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     *
     * @param  Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check() && ! Auth::user()->is_enable) {
            Auth::logout();
            Flash::error('Your Account is currently disabled, please contact to administrator.');

            return \Redirect::to('login');
        }

        return $response;
    }
}

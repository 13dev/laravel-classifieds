<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authorize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null, $permission = null)
    {
        /*
         * Check if User is admin By 13! :)
         * @var [Boolean]
         * 0 = User;
         * 1 = Admin!;
         *
         */
        if (Auth::Check()) {
            $userisAdmin = Auth::user()->is_admin;

            if ($userisAdmin == 0) {
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}

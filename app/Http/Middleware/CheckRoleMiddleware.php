<?php

namespace App\Http\Middleware;

use Closure;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ( ! \Auth::user()->{$role} )
        {
            return \App::abort(401, 'You are not allowed to access this resource.');
        }
        return $next($request);
    }
}

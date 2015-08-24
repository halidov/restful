<?php

namespace App\Http\Middleware;

use Closure;

class OnlineMiddleware
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
        auth()->user()->touch();
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class MyAuthenticateWithBasicAuth extends \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth
{
    public function handle($request, Closure $next)
    {
    	\Config::set('session.driver', 'array');
        return \Auth::onceBasic('login') ?: $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class MyAuthenticateWithBasicAuth extends \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth
{
    public function handle($request, Closure $next)
    {
        return $this->auth->basic('login') ?: $next($request);
    }
}

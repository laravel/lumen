<?php

namespace App\Http\Middleware;

use Closure;

class TealposBearerTokenMiddleware
{
    public function handle($request, Closure $next)
    {
        return $next($request);    
    }
}


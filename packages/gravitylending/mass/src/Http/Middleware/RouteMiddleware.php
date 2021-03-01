<?php

declare(strict_types=1);

namespace GravityLending\Mass\Http\Middleware;

use Closure;
use Laravel\Lumen\Http\Request;

class RouteMiddleware
{
    public function handle(Request $request, Closure $next, $class)
    {
        $request->attributes->set('model', 'App\\Models\\' . $class);
        return $next($request);
    }
}

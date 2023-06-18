<?php

namespace App\Http\Middleware;

use Closure;

class TranslatorAppMiddleware
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
        app('translator')->setLocale(env('Lang'));
        return $next($request);
    }
}

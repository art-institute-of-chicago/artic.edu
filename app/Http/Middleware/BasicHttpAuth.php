<?php

namespace App\Http\Middleware;

use Closure;

class BasicHttpAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Httpauth::secure();

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class PreferredDomain
{
    /**
     * Redirect to www if we're not on an accepted subdomain
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowIPForHealthCheck
{
    public function handle(Request $request, Closure $next)
    {
        // Only allow IP-based requests on the /health-check route
        if ($request->is('health-check') && filter_var($request->getHost(), FILTER_VALIDATE_IP)) {
            return $next($request);
        }

        // Block IP-based requests for other routes
        if (filter_var($request->getHost(), FILTER_VALIDATE_IP)) {
            abort(403, 'Forbidden'); // Deny access for other routes that have IP as Host header
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sanitize incoming query params: only allow valid search params to be returned in the response.
 * If disallowed params are present, redirect to the same URL with only allowed keys.
 */
class SanitizeQueryParameters
{
    const ROUTE_PARAM_KEY = 'allowed_query_params';

    protected $allowedQueryParameters = [
        'q',
        'page',
        // Checking to see if these are used by marketing
        // 'utm',
        // 'utm_campaign',
        // 'utm_content',
        // 'utm_medium',
        // 'utm_source',
        // 'utm_term',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $allowedParams = $request->route()->getAction(self::ROUTE_PARAM_KEY);
        $allowedParams = collect($allowedParams)
            ->merge($this->allowedQueryParameters)
            ->unique()
            ->filter()
            ->values()
            ->all();
        $currentQuery = $request->query();
        $sanitizedQuery = array_intersect_key($currentQuery, array_flip($allowedParams));

        if ($sanitizedQuery !== $currentQuery) {
            return redirect()->to($request->url() . (empty($sanitizedQuery) ? '' : ('?' . http_build_query($sanitizedQuery))));
        }

        return $next($request);
    }
}

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
    const IS_LANDING_PAGE_KEY = 'is_landing_page';

    protected $allowedQueryParameters = [
        'q',
        'page',
        // Checking to see if these are used by marketing
        'utm',
        'utm_campaign',
        'utm_content',
        'utm_medium',
        'utm_source',
        'utm_term',
    ];

    protected $landingPageAllowedQueryParameters = [
        // Publications
        'filter',
        'sort',
    ];
    public function handle(Request $request, Closure $next): Response
    {
        // Get any parameters defined in the routes
        $allowedParams = $request->route()->getAction(self::ROUTE_PARAM_KEY);

        // Merge it with out default list
        $allowedParams = collect($allowedParams)
            ->merge($this->allowedQueryParameters);

        // If it's a landing page, merge it with that list
        if ($request->route()->getAction(self::IS_LANDING_PAGE_KEY)) {
            $allowedParams = $allowedParams
                ->merge($this->landingPageAllowedQueryParameters);
        }

        // Clean up the list
        $allowedParams = $allowedParams
            ->unique()
            ->filter()
            ->values()
            ->all();

        // Sanitize the incoming request
        $currentQuery = $request->query();
        $sanitizedQuery = array_intersect_key($currentQuery, array_flip($allowedParams));

        if ($sanitizedQuery !== $currentQuery) {
            abort(400, 'Invalid parameters.');
        }

        return $next($request);
    }
}

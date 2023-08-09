<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LandingPage;
use App\Models\GenericPage;

class ResolvePageRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $slug = strtolower($request->path());

        if ($slug === "/") {
            $slug = "home";
        }

        $landingPageModel = LandingPage::published()->bySlug($slug)->first();

        if ($landingPageModel) {
            // To satisfy the HTTP protocol we need to generate a response from the controller as if we were going there

            // Create a new request here
            $newRequest = Request::create(
                route('landingPages.show', ['id' => $landingPageModel->landing_page_id, 'slug' => $slug]),
                'GET',
                [],
                $request->cookie(),
                [],
                $request->server()
            );

            // Send the new request to the controller and capture the response
            // Return the response as the middleware's response so Clockwork doesn't yell at us for violating req/res
            return app()->handle($newRequest);
        }

        return $next($request);
    }
}

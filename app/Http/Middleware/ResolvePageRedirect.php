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

        $landingPageModel = LandingPage::published()->join('landing_page_slugs', function ($join) use ($slug) {
            $join->on('landing_page_slugs.landing_page_id', 'landing_pages.id')
                 ->where('landing_page_slugs.slug', $slug)
                 ->where('landing_page_slugs.active', true);
        })->first();


        if ($landingPageModel) {
            // To satisfy the HTTP protocol we need to generate a response from the controller as if we were going there

            // Create a new request here
            $newRequest = Request::create(
                route('landingPages.show', ['id' => $landingPageModel->id, 'slug' => $slug]),
                'GET',
                [],
                $request->cookie(),
                [],
                $request->server()
            );

            // Send the new request to the controller and capture the response
            $response = app()->handle($newRequest);

            // Return the response as the middleware's response so Clockwork doesn't yell at us for violating req/res
            return $response;
        }

        $genericPageModel = GenericPage::published()->join('generic_page_slugs', function ($join) use ($slug) {
            $join->on('generic_page_slugs.generic_page_id', 'generic_pages.id')->where('generic_page_slugs.slug', $slug);
        })->first();


        if ($genericPageModel) {
            $newRequest = Request::create(
                route('genericPage.show', ['id' => $genericPageModel->id, 'slug' => $slug]),
                'GET',
                [],
                $request->cookie(),
                [],
                $request->server()
            );

            $response = app()->handle($newRequest);

            return $response;
        }

        return $next($request);
    }
}

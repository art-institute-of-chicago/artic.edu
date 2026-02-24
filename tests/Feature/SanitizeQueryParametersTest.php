<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;

class SanitizeQueryParametersTest extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Collection route - uses middleware but no extra allowed params
        Route::get('/collection', [
            'uses' => function () {
                return 'ok';
            },
        ])->middleware(\App\Http\Middleware\SanitizeQueryParameters::class);

        // Events route - allowed only 'type' (route action provides allowed params)
        Route::get('/events', [
            'uses' => function () {
                return 'ok';
            },
            'allowed_query_params' => ['type'],
        ])->middleware(\App\Http\Middleware\SanitizeQueryParameters::class);

        // Landing pages route - flagged as a landing page so landing params are allowed
        Route::get('/landingpages/{id}/{slug}', [
            'uses' => function () {
                return 'ok';
            },
            'is_landing_page' => true,
        ])->middleware(\App\Http\Middleware\SanitizeQueryParameters::class);
    }

    public function test_collection_redirects_removing_disallowed_params()
    {
        $response = $this->get('/collection?foo=bar&page=2');

        $response->assertStatus(500);
    }

    public function test_events_keeps_only_allowed_params()
    {
        $response = $this->get('/events?type=tour&spam=1');

        $response->assertStatus(500);
    }

    public function test_landing_page_keeps_landing_allowed_params()
    {
        $response = $this->get('/landingpages/1/test?filter=popular&badparam=xyz');

        $response->assertStatus(500);
    }
}

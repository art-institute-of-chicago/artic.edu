<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Models\Page;
use App\Models\Event;
use Aic\Hub\Foundation\Testing\MockApi;

class CollectionLandingTest extends BaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Page::firstOrCreate(['type' => 2], [
            'position' => 2,
            'published' => 1,
            'title' => 'Art & Artists'
        ]);
    }

    public function test_collection_landing_loads(): void
    {
        $response = $this->get(route('collection'));
        $response->assertStatus(200);
    }

    /**
     * A search with no results falls back to a predefined SEO image. This test verifies that the
     * fallback image is rendered as an og:image meta tag with a fully qualified URL using
     * the config's APP_URL (the legacy <meta itemprop="image"> microdata tag was removed in
     * favor of JSON-LD).
     */
    public function test_collection_landing_seo_image(): void
    {
        $response = $this->get(route('collection', ['q' => 'sdflisdfkuhsdfkughsdfkughsfd']));
        $html = preg_replace('/\s+/', ' ', $response->getContent());
        $this->assertStringContainsString('<meta property="og:image" content="http', $html);
        $this->assertStringContainsString('<meta property="og:image" content="' . config('app.url'), $html);
    }
}

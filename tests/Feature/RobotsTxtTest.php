<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use Illuminate\Support\Facades\Config;

class RobotsTxtTest extends BaseTestCase
{
    public function test_robots_txt_loads(): void
    {
        $response = $this->get(route('robots-txt'));
        $response->assertStatus(200);
    }

    public function test_blocks_all_traffic_when_not_production(): void
    {
        Config::set('app.env', 'testing');
        $response = $this->get(route('robots-txt'));
        $this->assertEquals("User-agent: *\nDisallow: /", $response->getContent());
    }

    public function test_blocks_all_traffic_when_production_but_different_domain(): void
    {
        Config::set('app.env', 'production');
        Config::set('app.debug', false);
        Config::set('app.url', 'www.example.com');
        $response = $this->get(route('robots-txt'));
        $this->assertEquals("User-agent: *\nDisallow: /", $response->getContent());
    }

    public function test_allow_traffic_when_production_request_to_same_host(): void
    {
        Config::set('app.env', 'production');
        Config::set('app.debug', false);

        $response = $this->get(route('robots-txt'));
        $this->assertNotEquals("User-agent: *\nDisallow: /", $response->getContent());
    }

    public function test_disallow_recently_viewed(): void
    {
        Config::set('app.env', 'production');
        Config::set('app.debug', false);

        $response = $this->get(route('robots-txt'));
        $this->assertStringContainsString("Disallow: /artworks/recentlyViewed", $response->getContent());
    }
}

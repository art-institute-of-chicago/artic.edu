<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Models\Experience;
use App\Repositories\ExperienceRepository;

class KioskTest extends BaseTestCase
{
    public function test_route_on_kiosk_subdomain(): void
    {
        $this->markTestIncomplete();
        $experience = Experience::factory()->create();
        $response = $this->get(config('app.kiosk_domain')[0] . "/interactive-features/$experience->slug");
        $response->assertStatus(200);

        $response = $this->get(config('app.kiosk_domain')[0] . '/interactive-features/non-existent-slug');
        $response->assertStatus(404);
    }

    public function test_route_on_website_domain_with_kiosk_path(): void
    {
        $this->markTestIncomplete();
        $experience = Experience::factory()->create();
        $response = $this->get("/interactive-features/kiosk/$experience->slug");
        $response->assertStatus(200);

        $response = $this->get("/interactive-features/kiosk/non-existent-slug");
        $response->assertStatus(404);
    }

    public function test_route_on_website(): void
    {
        $this->markTestIncomplete();
        $experience = Experience::factory()->create();
        $response = $this->get("/interactive-features/$experience->slug");
        $response->assertStatus(200);

        $response = $this->get("/interactive-features/non-existent-slug");
        $response->assertStatus(404);
    }
}

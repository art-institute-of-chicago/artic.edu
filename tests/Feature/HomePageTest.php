<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabaseState;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;

class HomePageTest extends BaseTestCase
{
    protected $seed = true;
    protected $forceRefresh = true;

    /** @test */
    public function it_loads_the_home_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_visit_page_links_appear_on_home_page()
    {
        $appUrl = config('APP_URL');
        $response = $this->get('/');
        $response->assertSee('Hours and admission fees');
        $response->assertSee("href=\"{$appUrl}/visit#hours\"", false);
        $response->assertSee('Directions and parking');
        $response->assertSee("href=\"{$appUrl}/visit#directions\"", false);
    }
}

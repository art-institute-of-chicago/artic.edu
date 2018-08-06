<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Page;

class PageTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_loads_the_home_page()
    {
        $page = factory(Page::class)->create(['type' => 0]);

        $response = $this->get('/');
        $response->assertStatus(200);
    }

}

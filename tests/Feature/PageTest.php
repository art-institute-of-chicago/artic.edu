<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Page;

class PageTest extends TestCase
{

    /** @test */
    public function it_loads_the_home_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

}

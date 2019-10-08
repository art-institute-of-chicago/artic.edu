<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Event;
use App\Models\EventMeta;
use App\Models\EventProgram;

class HourTest extends TestCase
{

    /** @test */
    public function it_shows_default_hours()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee("Open daily 10:30–5:00, Thursdays until 8:00");
    }

}

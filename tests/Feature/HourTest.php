<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Carbon\Carbon;

use App\Models\Hour;

class HourTest extends TestCase
{

    /** @test */
    public function it_shows_default_hours()
    {
        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee("Open daily 10:30–5:00, Thursdays until 8:00");
    }

    /** @test */
    public function it_shows_overriden_hours()
    {
        $hour = factory(Hour::class)->create([
            'title' => "Open 24 hours all week",
            'valid_from' => Carbon::now()->subWeek(),
            'valid_through' => Carbon::now()->addWeek(),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee("Open 24 hours all week");

        $hour->delete();
    }

}

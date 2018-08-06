<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Event;
use App\Models\EventProgram;

class EventTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_loads_events_by_program()
    {
        $eventProgram = factory(EventProgram::class)->create();
        $events = factory(Event::class, 2)->create()->each(function($event) use ($eventProgram) {
            $event->programs()->save($eventProgram);
        });

        /*
         * This request breaks due to SQLite's lack of support for `right join`s. I believe
         * the Event model's scopyByProgram method performs this query.
         * @TODO: Either refactor phpunit to spin up a temporary MySQL database for
         *   testing, or refactor queries to support SQLite's limited syntax.

        $response = $this->get('/events?program=' .$eventProgram->id);
        $response->assertStatus(200);

        // See two events
        foreach ($events as $event)
        {
            $response->assertSee($event->title);
        }

        // See results title
        $response->assertSee($eventProgram->name);
        */
    }

}

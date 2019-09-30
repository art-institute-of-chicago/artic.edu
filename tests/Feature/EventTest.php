<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Event;
use App\Models\EventMeta;
use App\Models\EventProgram;

class EventTest extends TestCase
{

    /** @test */
    public function it_loads_events_by_program()
    {
        $eventProgram = factory(EventProgram::class)->create();
        $events = factory(Event::class, 2)->create()->each(function($event) use ($eventProgram) {
            $event->programs()->attach($eventProgram->id);
            $event->eventMetas()->save(factory(EventMeta::class)->make(['event_id' => $event->id]));
            $event->save();
        });

        $response = $this->get('/events', [], ['program' => $eventProgram->id]);

        $response->assertStatus(200);

        // See two events
        foreach ($events as $event)
        {
            $response->assertSee($event->title);
        }

        // See results title
        $response->assertSee($eventProgram->name);
    }

    /**
     * Visit the given URI with a GET request.
     *
     * @param  string  $uri
     * @param  array  $headers
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    public function get($uri, array $headers = [], $parameters = [])
    {
        $server = $this->transformHeadersToServerVars($headers);

        return $this->call('GET', $uri, $parameters, [], [], $server);
    }
}

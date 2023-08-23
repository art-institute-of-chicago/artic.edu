<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Models\Event;
use App\Models\EventMeta;
use App\Models\EventProgram;

class EventTest extends BaseTestCase
{
    protected $seed = true;

    public function test_event_page_displays_events(): void
    {
        $response = $this->get(route('events'));
        $response->assertSee(Event::get()->pluck('title_display')->all());
    }

    public function test_event_page_loads_events_by_program(): void
    {
        $eventProgram = EventProgram::factory()->create();
        $events = Event::factory()->count(2)->create()->each(function ($event) use ($eventProgram) {
            $event->programs()->attach($eventProgram->id);
            $event->eventMetas()->save(EventMeta::factory()->make(['event_id' => $event->id]));
            $event->save();
        });

        $response = $this->get(route('events', ['program' => $eventProgram->id]));

        $response->assertStatus(200);

        // See two events
        foreach ($events as $event) {
            $response->assertSee($event->title);
        }

        // See results title
        $response->assertSee($eventProgram->name);
    }

    public function test_next_occurrence(): void
    {
        $eventProgram = EventProgram::factory()->create();
        $event = Event::factory()->create();
        $event->programs()->attach($eventProgram->id);
        $this->assertNull($event->nextOccurrence, "Events must have associated event metas with date data");

        $pastEvent = EventMeta::factory()->create([
            'event_id' => $event->id,
            'date' => now(),
            'date_end' => now()->subDay(),
        ]);
        $event->eventMetas()->save($pastEvent);
        $this->assertNull($event->nextOccurrence, "The next occurrence cannot have already ended");

        $futureEvent = EventMeta::factory()->create([
            'event_id' => $event->id,
            'date' => now(),
            'date_end' => now()->addDay(),
        ]);
        $event->eventMetas()->save($futureEvent);
        $this->assertNotNull($event->nextOccurrence, "The next occurrence must end in the future");
    }
}

<?php

namespace Tests\Feature;

use Aic\Hub\Foundation\Testing\FeatureTestCase as BaseTestCase;
use App\Models\Event;
use App\Models\EventMeta;
use App\Models\EventProgram;
use App\Models\Page;

class HomePageTest extends BaseTestCase
{
    protected $seed = true;
    protected $forceRefresh = true;

    public function test_home_page_loads(): void
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    public function test_visit_page_links_appear_on_home_page(): void
    {
        $response = $this->get(route('home'));
        $response->assertSee('Hours and admission fees');
        $response->assertSee("href=\"/visit#hours\"", false);
        $response->assertSee('Directions and parking');
        $response->assertSee("href=\"/visit#directions\"", false);
    }

    public function test_events_section_appears_on_home_page(): void
    {
        $response = $this->get(route('home'));
        $response->assertSee('Events');
        $response->assertSee('See upcoming events');
    }

    public function test_events_appear_on_home_page(): void
    {
        $fifthEvent = Event::factory()->create();
        $fifthEvent->programs()->attach(EventProgram::factory()->create()->id);
        $fifthEvent->eventMetas()->save(EventMeta::factory()->make(['event_id' => $fifthEvent->id, 'date_end' => now()->addYear()]));
        $fifthEvent->save();
        $homePage = Page::forType('Home')->first();
        $homePage->homeEvents()->attach([$fifthEvent->id => ['position' => 5]]);
        $this->assertDatabaseCount('events', 5);

        $events = Event::get();
        $response = $this->get(route('home'));
        $response->assertSee($events->take(4)->pluck('title_display')->all(), 'Home page displays first four events');
        $response->assertDontSee($events->last()->title_display, 'Home page displays only the first four events');
    }

    public function test_events_times_appear_on_home_page(): void
    {
        $response = $this->get(route('home'));
        $forcedFormattedDates = Event::whereNotNull('forced_date')->get()->pluck('forced_date')->all();
        $response->assertSee($forcedFormattedDates, 'Home page displays forced formatted dates as they are');

        $dynamicallyFormattedDates = Event::whereNull('forced_date')->get()->map(function ($event) {
            return $event->nextOccurrence->date->format('l, F j');  // [weekday], [month] [day of month]
        })->all();
        $response->assertSee($dynamicallyFormattedDates, 'Home page displays dynamically formatted dates');
    }
}

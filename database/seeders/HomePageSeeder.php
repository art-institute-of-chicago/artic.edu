<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Page;
use Illuminate\Database\Seeder;

/**
 * This relies on EventSeeder being run first.
 */
class HomePageSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::forType('Home')->first();
        $page->home_plan_your_visit_link_1_text = 'Hours and admission fees';
        $page->home_plan_your_visit_link_1_url = '/visit#hours';
        $page->home_plan_your_visit_link_2_text = 'Directions and parking';
        $page->home_plan_your_visit_link_2_url = '/visit#directions';
        $page->save();

        $events = Event::limit(4)->get();  # The home page needs four events
        for ($index = 0; $index < $events->count(); $index++) {
            $position = $index + 1;
            $page->homeEvents()->attach([$events[$index]->id => ['position' => $position]]);
        }
    }
}

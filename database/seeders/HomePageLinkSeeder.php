<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class HomePageLinkSeeder extends Seeder
{
    public function run(): void
    {
        $page = Page::forType('Home')->first();
        $page->home_plan_your_visit_link_1_text = 'Hours and admission fees';
        $page->home_plan_your_visit_link_1_url = '/visit#hours';
        $page->home_plan_your_visit_link_2_text = 'Directions and parking';
        $page->home_plan_your_visit_link_2_url = '/visit#directions';
        $page->save();
    }
}

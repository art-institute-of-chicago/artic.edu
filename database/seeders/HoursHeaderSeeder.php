<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class HoursHeaderSeeder extends Seeder
{
    public function run(): void
    {
        $visitPage = \App\Models\Page::where('type', 3)->first();

        $visitPage->visit_hour_header = '* The first hour of each day is accessible to museum members only';
        $visitPage->visit_hour_subheader = '<p>All dining spaces, libraries, meeting halls, and the Ryan Learning Center are closed until further notice.</p>';
        $visitPage->save();
    }
}

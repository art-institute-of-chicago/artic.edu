<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ParkingAccessibilityLinkSeeder extends Seeder
{
    public function run(): void
    {
        $visitPage = \App\Models\Page::where('type', 3)->first();

        $visitPage->visit_parking_accessibility_link = '/visit/accessibility/visitors-with-mobility-needs';
        $visitPage->save();
    }
}

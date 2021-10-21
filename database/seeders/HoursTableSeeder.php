<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hour;

class HoursTableSeeder extends Seeder
{
    public function run()
    {
        foreach (Hour::$days as $day => $dayName) {
            foreach (Hour::$types as $type => $typeName) {
                $page = Hour::firstOrNew(['type' => $type, 'day_of_week' => $day], [
                    'day_of_week' => $day,
                    'type' => $type
                ]);

                $page->save();
            }
        }
    }
}

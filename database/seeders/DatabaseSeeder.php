<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PagesTableSeeder::class,
            HoursTableSeeder::class,
            EventProgramSeeder::class,
            EventSeeder::class,
            IlluminateTagSeeder::class,
            MyMuseumTourSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

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

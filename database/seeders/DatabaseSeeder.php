<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public $seeders = [
        PagesTableSeeder::class,
        HoursTableSeeder::class,
        EventProgramSeeder::class,
        EventSeeder::class,
        IlluminateTagSeeder::class,
        MyMuseumTourSeeder::class,
    ];

    public function run(): void
    {
        foreach ($this->seeders as $seeder) {
            $this->call($seeder);
        }
    }
}

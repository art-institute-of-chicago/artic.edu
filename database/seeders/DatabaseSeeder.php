<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public $seeders = [
        PagesTableSeeder::class,
        HoursTableSeeder::class,
        HomePageLinkSeeder::class,
        MembershipMagazinePageSeeder::class,
    ];

    public function run(): void
    {
        $this->call(PagesTableSeeder::class);
        $this->call(HoursTableSeeder::class);
    }
}

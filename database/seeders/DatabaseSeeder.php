<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public $seeders = [
        PagesTableSeeder::class,
        HoursTableSeeder::class,
        HomePageSeeder::class,
        MembershipMagazinePageSeeder::class,
        VisitPageSeeder::class,
        EmailSeriesSeeder::class,
        TranslationsSeeder::class,
        EventProgramSeeder::class,
        PublishStartDateSeeder::class,
        RelatedArticlesSeeder::class,
        MembershipBannerSeeder::class,
        VanityRedirectSeeder::class,
    ];

    public function run(): void
    {
        $this->call(PagesTableSeeder::class);
        $this->call(HoursTableSeeder::class);
    }
}

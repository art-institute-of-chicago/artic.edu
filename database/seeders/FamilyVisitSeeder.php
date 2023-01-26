<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FamilyPageSeeder extends Seeder
{
    public function run(): void
    {
        $visitPage = \App\Models\Page::where('type', 3)->first();

        $visitPage->families()->delete();

        $family = new \App\Models\Family();
        $family->translateOrNew('en')->title = 'Art Institute Mobile App';
        $family->translateOrNew('en')->text = 'The Art Institute\'s free app offers the stories behind the art through conversations with artists, experts, and community members. Download it via the App Store or Google Play.';
        $family->translateOrNew('en')->link_label = 'Learn more';
        $family->translateOrNew('en')->active = true;
        $family->published = true;
        $family->external_link = '/visit/explore-on-your-own/mobile-app-audio-tours';
        $family->position = 1;
        $family->page_id = $visitPage->id;
        $family->save();

        $family = new \App\Models\Family();
        $family->translateOrNew('en')->title = 'What to See in an Hour';
        $family->translateOrNew('en')->text = 'Short on time? Check out this must-see guide to the collection.';
        $family->translateOrNew('en')->link_label = 'More custom tours';
        $family->translateOrNew('en')->active = true;
        $family->published = true;
        $family->external_link = '/highlights';
        $family->position = 2;
        $family->page_id = $visitPage->id;
        $family->save();

        $family = new \App\Models\Family();
        $family->translateOrNew('en')->title = 'Visit Us Virtually';
        $family->translateOrNew('en')->text = 'Even from afar, there\'s a host of ways to connect to our collection of art from around the world&mdash;whether you\'re seeking inspiration, community, or a little adventure.';
        $family->translateOrNew('en')->link_label = 'Learn more';
        $family->translateOrNew('en')->active = true;
        $family->published = true;
        $family->external_link = '/visit-us-virtually';
        $family->position = 3;
        $family->page_id = $visitPage->id;
        $family->save();
    }
}

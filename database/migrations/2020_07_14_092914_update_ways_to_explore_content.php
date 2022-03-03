<?php

use Illuminate\Database\Migrations\Migration;

class UpdateWaysToExploreContent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (env('APP_ENV') != 'testing') {
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (env('APP_ENV') != 'testing') {
            $visitPage = \App\Models\Page::where('type', 3)->first();

            $visitPage->families()->delete();

            $family = new \App\Models\Family();
            $family->translateOrNew('en')->title = 'Families';
            $family->translateOrNew('en')->text = 'Explore family-friendly art-making activities and interactive spaces.';
            $family->translateOrNew('en')->link_label = 'See upcoming family events';
            $family->translateOrNew('en')->active = true;
            $family->published = true;
            $family->external_link = '/events?audience=1';
            $family->position = 1;
            $family->page_id = $visitPage->id;
            $family->save();

            $family = new \App\Models\Family();
            $family->translateOrNew('en')->title = 'Teens';
            $family->translateOrNew('en')->text = 'Find yourself here. Look at art. Make art. Talk about life. Meet new people. Be inspired.';
            $family->translateOrNew('en')->link_label = 'See upcoming teen events';
            $family->translateOrNew('en')->active = true;
            $family->published = true;
            $family->external_link = '/events?audience=4';
            $family->position = 2;
            $family->page_id = $visitPage->id;
            $family->save();

            $family = new \App\Models\Family();
            $family->translateOrNew('en')->title = 'Educators';
            $family->translateOrNew('en')->text = 'Explore diverse resources and dynamic professional development offerings for K–12 educators.';
            $family->translateOrNew('en')->link_label = 'See upcoming events for educators';
            $family->translateOrNew('en')->active = true;
            $family->published = true;
            $family->external_link = '/events?audience=6';
            $family->position = 3;
            $family->page_id = $visitPage->id;
            $family->save();
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VisitPageSeeder extends Seeder
{
    public function run(): void
    {
        $visitPage = \App\Models\Page::where('type', 3)->first();

        $visitPage->translate('en')->visit_hour_intro = 'The Art Institute reopens on July 30, and we\'re so happy to welcome you back to our galleries. Please see below for new hours—including member-only hours—and updated safety policies.';
        $visitPage->translate('en')->visit_hour_header = 'Member-Only Hours';
        $visitPage->translate('en')->visit_hour_subheader = '<p>Monday 10&ndash;11 a.m.<br/>Thursday&ndash;Friday 12-1 p.m.<br/>Saturday&ndash;Sunday 10&ndash;11 a.m.</p>';
        $visitPage->translate('en')->visit_admission_description = '<p>The Art Institute of Chicago provides free access to children under 14, Chicago teens under 18, Link and WIC cardholders, and Illinois educators every day, and to Illinois residents on certain days throughout the year. <a href="/visit/free-admission" target="_blank">Learn more<span class="sr-only"> about free access</span></a>.</p>';
        $visitPage->translate('en')->visit_accessibility_text = 'The Art Institute of Chicago welcomes all visitors and is committed to making its services accessible to everyone. We offer a range of resources for both adults and children with disabilities.';
        $visitPage->translate('en')->visit_accessibility_link_text = 'Learn more about accessibility';
        $visitPage->translate('en')->visit_parking_accessibility_link = '/visit/accessibility/visitors-with-mobility-needs';

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

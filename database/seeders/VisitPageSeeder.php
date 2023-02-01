<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VisitPageSeeder extends Seeder
{
    public function run(): void
    {
        // XXX Even when pre-seeded with this visit page, this errors out with the same error as PageTableSeeder
        $visitPage = \App\Models\Page::firstOrNew(['type' => 3]);

        $visitPage->visit_hour_intro = 'The Art Institute reopens on July 30, and we\'re so happy to welcome you back to our galleries. Please see below for new hours—including member-only hours—and updated safety policies.';
        $visitPage->visit_hour_header = 'Member-Only Hours';
        $visitPage->visit_hour_subheader = '<p>Monday 10&ndash;11 a.m.<br/>Thursday&ndash;Sunday 10-11 a.m.</p>';
        $visitPage->visit_admission_description = '<p>The Art Institute of Chicago provides free access to children under 14, Chicago teens under 18, Link and WIC cardholders, and Illinois educators every day, and to Illinois residents on certain days throughout the year. <a href="/visit/free-admission" target="_blank">Learn more<span class="sr-only"> about free access</span></a>.</p>';
        $visitPage->visit_accessibility_text = 'The Art Institute of Chicago welcomes all visitors and is committed to making its services accessible to everyone. We offer a range of resources for both adults and children with disabilities.';
        $visitPage->visit_accessibility_link_text = 'Learn more about accessibility';
        $visitPage->visit_parking_accessibility_link = '/visit/accessibility/visitors-with-mobility-needs';
        $visitPage->save();

        // XXX All of the following should use firstOrNew or updateOrInsert so that this can be run multiple times in a row
        $family = new \App\Models\Family();
        $family->title = 'Art Institute Mobile App';
        $family->text = 'The Art Institute\'s free app offers the stories behind the art through conversations with artists, experts, and community members. Download it via the App Store or Google Play.';
        $family->link_label = 'Learn more';
        $family->active = true;
        $family->published = true;
        $family->external_link = '/visit/explore-on-your-own/mobile-app-audio-tours';
        $family->position = 1;
        $family->page_id = $visitPage->id;
        $family->save();

        $family = new \App\Models\Family();
        $family->title = 'What to See in an Hour';
        $family->text = 'Short on time? Check out this must-see guide to the collection.';
        $family->link_label = 'More custom tours';
        $family->active = true;
        $family->published = true;
        $family->external_link = '/highlights';
        $family->position = 2;
        $family->page_id = $visitPage->id;
        $family->save();

        $family = new \App\Models\Family();
        $family->title = 'Visit Us Virtually';
        $family->text = 'Even from afar, there\'s a host of ways to connect to our collection of art from around the world&mdash;whether you\'re seeking inspiration, community, or a little adventure.';
        $family->link_label = 'Learn more';
        $family->active = true;
        $family->published = true;
        $family->external_link = '/visit-us-virtually';
        $family->position = 3;
        $family->page_id = $visitPage->id;
        $family->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 0;
        $whatToExpect->text = 'Face coverings will be required for your entire museum visit.';
        $whatToExpect->active = true;
        $whatToExpect->published = true;
        $whatToExpect->position = 1;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 1;
        $whatToExpect->text = 'Maintain a physical distance of six-feet from staff and visitors.';
        $whatToExpect->active = true;
        $whatToExpect->published = true;
        $whatToExpect->position = 2;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 2;
        $whatToExpect->text = 'Advance ticket purchase is required. Members will be required to display digital member card using the Art Institute of Chicago mobile app.';
        $whatToExpect->active = true;
        $whatToExpect->published = true;
        $whatToExpect->position = 3;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 3;
        $whatToExpect->text = 'Anyone feeling unwell should postpone their visit for another time.';
        $whatToExpect->active = true;
        $whatToExpect->published = true;
        $whatToExpect->position = 4;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 4;
        $whatToExpect->text = 'Our checkrooms are currently closed. Pack light, and remember some items are not allowed in the galleries.';
        $whatToExpect->active = true;
        $whatToExpect->published = true;
        $whatToExpect->position = 5;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 5;
        $whatToExpect->text = 'Our amenities are temporarily limited. Service and spaces currently unavailable include restaurants, auditoria, valet service, and the Member Lounge.';
        $whatToExpect->active = true;
        $whatToExpect->published = true;
        $whatToExpect->position = 6;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 6;
        $whatToExpect->text = 'Some galleries may have limited capacity or be temporarily closed.';
        $whatToExpect->active = true;
        $whatToExpect->published = true;
        $whatToExpect->position = 7;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 7;
        $whatToExpect->text = 'Be mindful to abide by directional signage, including designated entrances and exits.';
        $whatToExpect->active = true;
        $whatToExpect->published = true;
        $whatToExpect->position = 8;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 8;
        $whatToExpect->text = 'Special exhibitions may use timed queueing systems. Check in at exhibition entrances to reserve your spot in line.';
        $whatToExpect->active = true;
        $whatToExpect->published = true;
        $whatToExpect->position = 9;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();
    }
}

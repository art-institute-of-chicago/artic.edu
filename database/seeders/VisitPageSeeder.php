<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VisitPageSeeder extends Seeder
{
    public function run(): void
    {



        $family = new \App\Models\Family();
        $family->title = 'Art Institute Mobile App';
        $family->text = 'The Art Institute\'s free app offers the stories behind the art through conversations with artists, experts, and community members. Download it via the App Store or Google Play.';
        $family->link_label = 'Learn more';
        $family->published = true;
        $family->external_link = '/visit/explore-on-your-own/mobile-app-audio-tours';
        $family->position = 1;
        $family->page_id = $visitPage->id;
        $family->save();

        $family = new \App\Models\Family();
        $family->title = 'What to See in an Hour';
        $family->text = 'Short on time? Check out this must-see guide to the collection.';
        $family->link_label = 'More custom tours';
        $family->published = true;
        $family->external_link = '/highlights';
        $family->position = 2;
        $family->page_id = $visitPage->id;
        $family->save();

        $family = new \App\Models\Family();
        $family->title = 'Visit Us Virtually';
        $family->text = 'Even from afar, there\'s a host of ways to connect to our collection of art from around the world&mdash;whether you\'re seeking inspiration, community, or a little adventure.';
        $family->link_label = 'Learn more';
        $family->published = true;
        $family->external_link = '/visit-us-virtually';
        $family->position = 3;
        $family->page_id = $visitPage->id;
        $family->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 0;
        $whatToExpect->text = 'Face coverings will be required for your entire museum visit.';
        $whatToExpect->published = true;
        $whatToExpect->position = 1;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 1;
        $whatToExpect->text = 'Maintain a physical distance of six-feet from staff and visitors.';
        $whatToExpect->published = true;
        $whatToExpect->position = 2;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 2;
        $whatToExpect->text = 'Advance ticket purchase is required. Members will be required to display digital member card using the Art Institute of Chicago mobile app.';
        $whatToExpect->published = true;
        $whatToExpect->position = 3;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 3;
        $whatToExpect->text = 'Anyone feeling unwell should postpone their visit for another time.';
        $whatToExpect->published = true;
        $whatToExpect->position = 4;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 4;
        $whatToExpect->text = 'Our checkrooms are currently closed. Pack light, and remember some items are not allowed in the galleries.';
        $whatToExpect->published = true;
        $whatToExpect->position = 5;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 5;
        $whatToExpect->text = 'Our amenities are temporarily limited. Service and spaces currently unavailable include restaurants, auditoria, valet service, and the Member Lounge.';
        $whatToExpect->published = true;
        $whatToExpect->position = 6;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 6;
        $whatToExpect->text = 'Some galleries may have limited capacity or be temporarily closed.';
        $whatToExpect->published = true;
        $whatToExpect->position = 7;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 7;
        $whatToExpect->text = 'Be mindful to abide by directional signage, including designated entrances and exits.';
        $whatToExpect->published = true;
        $whatToExpect->position = 8;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();

        $whatToExpect = new \App\Models\WhatToExpect();
        $whatToExpect->icon_type = 8;
        $whatToExpect->text = 'Special exhibitions may use timed queueing systems. Check in at exhibition entrances to reserve your spot in line.';
        $whatToExpect->published = true;
        $whatToExpect->position = 9;
        $whatToExpect->page_id = $visitPage->id;
        $whatToExpect->save();
    }
}

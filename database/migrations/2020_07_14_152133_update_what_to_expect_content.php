<?php

use Illuminate\Database\Migrations\Migration;

class UpdateWhatToExpectContent extends Migration
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

            $visitPage->whatToExpects()->delete();

            $whatToExpect = new \App\Models\WhatToExpect();
            $whatToExpect->icon_type = 0;
            $whatToExpect->translateOrNew('en')->text = 'Face coverings will be required for your entire museum visit.';
            $whatToExpect->translateOrNew('en')->active = true;
            $whatToExpect->published = true;
            $whatToExpect->position = 1;
            $whatToExpect->page_id = $visitPage->id;
            $whatToExpect->save();

            $whatToExpect = new \App\Models\WhatToExpect();
            $whatToExpect->icon_type = 1;
            $whatToExpect->translateOrNew('en')->text = 'Maintain a physical distance of six-feet from staff and visitors.';
            $whatToExpect->translateOrNew('en')->active = true;
            $whatToExpect->published = true;
            $whatToExpect->position = 2;
            $whatToExpect->page_id = $visitPage->id;
            $whatToExpect->save();

            $whatToExpect = new \App\Models\WhatToExpect();
            $whatToExpect->icon_type = 2;
            $whatToExpect->translateOrNew('en')->text = 'Advance ticket purchase is required. Members will be required to display digital member card using the Art Institute of Chicago mobile app.';
            $whatToExpect->translateOrNew('en')->active = true;
            $whatToExpect->published = true;
            $whatToExpect->position = 3;
            $whatToExpect->page_id = $visitPage->id;
            $whatToExpect->save();

            $whatToExpect = new \App\Models\WhatToExpect();
            $whatToExpect->icon_type = 3;
            $whatToExpect->translateOrNew('en')->text = 'Anyone feeling unwell should postpone their visit for another time.';
            $whatToExpect->translateOrNew('en')->active = true;
            $whatToExpect->published = true;
            $whatToExpect->position = 4;
            $whatToExpect->page_id = $visitPage->id;
            $whatToExpect->save();

            $whatToExpect = new \App\Models\WhatToExpect();
            $whatToExpect->icon_type = 4;
            $whatToExpect->translateOrNew('en')->text = 'Our checkrooms are currently closed. Pack light, and remember some items are not allowed in the galleries.';
            $whatToExpect->translateOrNew('en')->active = true;
            $whatToExpect->published = true;
            $whatToExpect->position = 5;
            $whatToExpect->page_id = $visitPage->id;
            $whatToExpect->save();

            $whatToExpect = new \App\Models\WhatToExpect();
            $whatToExpect->icon_type = 5;
            $whatToExpect->translateOrNew('en')->text = 'Our amenities are temporarily limited. Service and spaces currently unavailable include restaurants, auditoria, valet service, and the Member Lounge.';
            $whatToExpect->translateOrNew('en')->active = true;
            $whatToExpect->published = true;
            $whatToExpect->position = 6;
            $whatToExpect->page_id = $visitPage->id;
            $whatToExpect->save();

            $whatToExpect = new \App\Models\WhatToExpect();
            $whatToExpect->icon_type = 6;
            $whatToExpect->translateOrNew('en')->text = 'Some galleries may have limited capacity or be temporarily closed.';
            $whatToExpect->translateOrNew('en')->active = true;
            $whatToExpect->published = true;
            $whatToExpect->position = 7;
            $whatToExpect->page_id = $visitPage->id;
            $whatToExpect->save();

            $whatToExpect = new \App\Models\WhatToExpect();
            $whatToExpect->icon_type = 7;
            $whatToExpect->translateOrNew('en')->text = 'Be mindful to abide by directional signage, including designated entrances and exits.';
            $whatToExpect->translateOrNew('en')->active = true;
            $whatToExpect->published = true;
            $whatToExpect->position = 8;
            $whatToExpect->page_id = $visitPage->id;
            $whatToExpect->save();

            $whatToExpect = new \App\Models\WhatToExpect();
            $whatToExpect->icon_type = 8;
            $whatToExpect->translateOrNew('en')->text = 'Special exhibitions may use timed queueing systems. Check in at exhibition entrances to reserve your spot in line.';
            $whatToExpect->translateOrNew('en')->active = true;
            $whatToExpect->published = true;
            $whatToExpect->position = 9;
            $whatToExpect->page_id = $visitPage->id;
            $whatToExpect->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $visitPage = \App\Models\Page::where('type', 3)->first();

        $visitPage->whatToExpects()->delete();
    }
}

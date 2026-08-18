<?php

namespace Tests\Unit\Stubs;

use Carbon\Carbon;

class StubEvent
{
    public $id = 7;

    public $title = 'Member Preview Night';

    public $short_description = '<p>Join us for a preview.</p>';

    public $location = 'Gallery 101';

    public $is_virtual_event = false;

    public $is_free = true;

    public $is_ticketed = false;

    public $is_sold_out = false;

    public $audience = 3;

    public $alt_audiences = [];

    public $event_type = 5;

    public $alt_types = [];

    public $rsvp_link = 'https://www.artic.edu/rsvp';

    public $door_time = '18:00';

    public $slug = 'member-preview-night';

    public $date_start;

    public $date_end;

    public function __construct()
    {
        $this->date_start = Carbon::parse('2024-06-01 18:00:00');
        $this->date_end = Carbon::parse('2024-06-01 21:00:00');
    }

    public function imageFront($role = 'hero', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/evt/full/!3000,3000/0/default.jpg'];
    }
}

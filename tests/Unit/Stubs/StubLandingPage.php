<?php

namespace Tests\Unit\Stubs;

use Carbon\Carbon;

class StubLandingPage
{
    public $id = 141;

    public $title = 'Visit';

    public $listing_description = '<p>Plan your visit to the museum.</p>';

    public $updated_at;

    public function __construct()
    {
        $this->updated_at = Carbon::parse('2024-05-01');
    }

    public function getSlug()
    {
        return 'home';
    }

    public function imageFront($role = 'hero', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/landing/full/!3000,3000/0/default.jpg'];
    }
}

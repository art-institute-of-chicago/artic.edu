<?php

namespace Tests\Unit\Stubs;

use Carbon\Carbon;

class StubGenericPage
{
    public $id = 121;

    public $title = 'Visit with My Students';

    public $short_description = '<p>Plan your school visit.</p>';

    public $listing_description = '<p>Resources for educators.</p>';

    public $url = '/visit/visit-with-my-students';

    public $updated_at;

    public function __construct()
    {
        $this->updated_at = Carbon::parse('2024-03-05');
    }

    public function imageFront($role = 'listing', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/generic/full/!3000,3000/0/default.jpg'];
    }
}

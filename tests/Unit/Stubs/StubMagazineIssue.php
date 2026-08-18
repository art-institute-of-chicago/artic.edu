<?php

namespace Tests\Unit\Stubs;

use Carbon\Carbon;

class StubMagazineIssue
{
    public $id = 41;

    public $title = 'Fall 2024';

    public $list_description = '<p>The fall issue of the museum magazine.</p>';

    public $publish_start_date;

    public function __construct()
    {
        $this->publish_start_date = Carbon::parse('2024-09-01');
    }

    public function getSlug()
    {
        return 'fall-2024';
    }

    public function imageFront($role = 'hero', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/issue/full/!3000,3000/0/default.jpg'];
    }
}

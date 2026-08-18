<?php

namespace Tests\Unit\Stubs;

use Carbon\Carbon;

class StubDigitalPublication
{
    public $id = 61;

    public $title = 'Impressionism and Beyond';

    public $listing_description = '<p>An interactive digital publication.</p>';

    public $publication_date;

    public function __construct()
    {
        $this->publication_date = Carbon::parse('2024-01-20');
    }

    public function getSlug()
    {
        return 'impressionism-and-beyond';
    }

    public function imageFront($role = 'listing', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/digipub/full/!3000,3000/0/default.jpg'];
    }
}

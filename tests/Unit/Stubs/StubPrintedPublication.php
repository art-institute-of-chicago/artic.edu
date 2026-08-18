<?php

namespace Tests\Unit\Stubs;

use Carbon\Carbon;

class StubPrintedPublication
{
    public $id = 51;

    public $title = 'Van Gogh: The Complete Works';

    public $short_description = '<p>A comprehensive survey.</p>';

    public $listing_description = '<p>The definitive catalogue.</p>';

    public $publication_date;

    public $isbn = '978-0-86559-000-0';

    public $number_of_pages = 320;

    public function __construct()
    {
        $this->publication_date = Carbon::parse('2023-11-15');
    }

    public function getSlug()
    {
        return 'van-gogh-the-complete-works';
    }

    public function imageFront($role = 'listing', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/book/full/!3000,3000/0/default.jpg'];
    }
}

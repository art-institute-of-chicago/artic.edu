<?php

namespace Tests\Unit\Stubs;

use Carbon\Carbon;

class StubDigitalExplorer
{
    public $id = 131;

    public $title = 'The Giltwood Table';

    public $listing_description = '<p>A 3D exploration of an object.</p>';

    public $updated_at;

    public function __construct()
    {
        $this->updated_at = Carbon::parse('2024-04-10');
    }

    public function getSlug()
    {
        return 'the-giltwood-table';
    }

    public function imageFront($role = 'listing', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/explorer/full/!3000,3000/0/default.jpg'];
    }
}

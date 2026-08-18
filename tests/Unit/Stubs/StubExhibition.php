<?php

namespace Tests\Unit\Stubs;

use Carbon\Carbon;

class StubExhibition
{
    public $id = 42;

    public $title = 'Van Gogh and the Avant-Garde';

    public $list_description = '<p>An exhibition about Van Gogh.</p>';

    public $gallery_title = 'Gallery 100';

    public $titleSlug = 'van-gogh-and-the-avant-garde';

    public $date_start;

    public $date_end;

    public function __construct()
    {
        $this->date_start = Carbon::parse('2024-05-01');
        $this->date_end = Carbon::parse('2024-09-08');
    }

    public function imageFront($role = 'hero', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/xyz/full/!3000,3000/0/default.jpg'];
    }
}

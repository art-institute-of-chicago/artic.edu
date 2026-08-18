<?php

namespace Tests\Unit\Stubs;

class StubHighlight
{
    public $id = 11;

    public $title = 'A Closer Look at Nighthawks';

    public $short_copy = '<p>Explore Edward Hopper\'s iconic painting.</p>';

    public function getSlug()
    {
        return 'a-closer-look-at-nighthawks';
    }

    public function imageFront($role = 'hero', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/highlight/full/!3000,3000/0/default.jpg'];
    }
}

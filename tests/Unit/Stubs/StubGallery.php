<?php

namespace Tests\Unit\Stubs;

class StubGallery
{
    public $id = 2;

    public $title = 'Gallery 100';

    public $description = '<p>A gallery of European art.</p>';

    public $latitude = 41.8796;

    public $longitude = -87.6237;

    public $titleSlug = 'gallery-100';

    public function imageFront($role = 'hero', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/gallery/full/!3000,3000/0/default.jpg'];
    }
}

<?php

namespace Tests\Unit\Stubs;

class StubExperience
{
    public $id = 91;

    public $title = 'The Thread in the Labyrinth';

    public $listing_description = '<p>An interactive feature about the Thorne Miniature Rooms.</p>';

    public $subtitle = 'Explore the miniature rooms';

    public function getSlug()
    {
        return 'the-thread-in-the-labyrinth';
    }

    public function imageFront($role = 'thumbnail', $crop = 'default')
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/experience/full/!3000,3000/0/default.jpg'];
    }
}

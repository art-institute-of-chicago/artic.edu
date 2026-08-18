<?php

namespace Tests\Unit\Stubs;

class StubAuthor
{
    public $id = 5;

    public $title = 'Jane Doe';

    public $description = '<p>An art historian and writer.</p>';

    public $list_description = '<p>Short list description.</p>';

    public $job_title = 'Curator';

    public function getSlug()
    {
        return 'jane-doe';
    }

    public function imageFront($role = 'hero', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/author/full/!3000,3000/0/default.jpg'];
    }
}

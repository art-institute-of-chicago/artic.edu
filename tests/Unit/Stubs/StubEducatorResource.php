<?php

namespace Tests\Unit\Stubs;

class StubEducatorResource
{
    public $id = 81;

    public $title = 'The Language of Color';

    public $short_description = '<p>A classroom resource about color theory.</p>';

    public $listing_description = '<p>Activities for students.</p>';

    public $categories;

    public function __construct()
    {
        $this->categories = collect([
            (object) ['name' => 'High School', 'type' => 'audience'],
            (object) ['name' => 'Lesson Plan', 'type' => 'content'],
        ]);
    }

    public function getSlug()
    {
        return 'the-language-of-color';
    }

    public function imageFront($role = 'listing', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/educator/full/!3000,3000/0/default.jpg'];
    }
}

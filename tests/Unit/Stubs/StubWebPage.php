<?php

namespace Tests\Unit\Stubs;

use Carbon\Carbon;

class StubWebPage
{
    public $id = 151;

    public $title = 'Plan Your Visit';

    public $description = '<p>Everything you need to know before you arrive.</p>';

    public $list_description = '<p>A shorter listing description.</p>';

    public $updated_at;

    public function __construct()
    {
        $this->updated_at = Carbon::parse('2024-06-01');
    }

    public function getSlug()
    {
        return 'plan-your-visit';
    }

    public function imageFront($role = 'hero', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/webpage/full/!3000,3000/0/default.jpg'];
    }
}

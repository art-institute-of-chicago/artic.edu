<?php

namespace Tests\Unit\Stubs;

use Carbon\Carbon;

class StubDigitalPublicationArticle
{
    public $id = 71;

    public $title = 'Monet in the Garden';

    public $list_description = '<p>How Monet composed his garden paintings.</p>';

    public $article_type = 'text';

    public $date;

    public $authors;

    public $digitalPublication;

    public function __construct()
    {
        $this->date = Carbon::parse('2024-02-01');
        $this->authors = collect([
            (object) ['title' => 'Jane Doe'],
        ]);
        $this->digitalPublication = new StubDigitalPublication();
    }

    public function getSlug()
    {
        return 'monet-in-the-garden';
    }

    public function imageFront($role = 'hero', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/digipart/full/!3000,3000/0/default.jpg'];
    }
}

<?php

namespace Tests\Unit\Stubs;

use Carbon\Carbon;

class StubArticle
{
    public $id = 99;

    public $title = 'Five Things to Know';

    public $heading = '<p>An introduction to the exhibition.</p>';

    public $list_description = '<p>Five things you need to know about the show.</p>';

    public $author_display = null;

    public $article_type = 'editorial';

    public $slug = 'five-things-to-know';

    public $date;

    public $updated_at;

    public $authors;

    public $categories;

    public function __construct()
    {
        $this->date = Carbon::parse('2024-03-15');
        $this->updated_at = Carbon::parse('2024-04-01');
        $this->authors = collect([
            (object) ['title' => 'Jane Doe'],
            (object) ['title' => 'John Smith'],
        ]);
        $this->categories = collect([
            (object) ['name' => 'Art + Technology'],
            (object) ['name' => 'Exhibitions'],
        ]);
    }

    public function imageFront($role = 'hero', $crop = null)
    {
        return ['src' => 'https://lakeimagesweb.artic.edu/iiif/2/art/full/!3000,3000/0/default.jpg'];
    }
}

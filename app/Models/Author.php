<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use App\Models\Behaviors\HasMediasEloquent;

class Author extends AbstractModel
{
    use HasSlug, HasMedias, HasRevisions, HasMediasEloquent;

    protected $fillable = [
        'published',
        'title',
        'description',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published'
    ];

    protected $presenter = 'App\Presenters\Admin\AuthorPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\AuthorPresenter';

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => '1',
                ],
            ]
        ],
    ];

    public function articles()
    {
        return $this->morphedByMany('App\Models\Article', 'authorable');
    }

    public function highlights()
    {
        return $this->morphedByMany('App\Models\Selection', 'authorable');
    }

    public function experiences()
    {
        return $this->morphedByMany('App\Models\Experience', 'authorable');
    }

    public function issueArticle()
    {
        return $this->morphedByMany('App\Models\IssueArticle', 'authorable');
    }
}

<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;

class Article extends Model
{
    use HasSlug, HasRevisions, HasMedias, HasBlocks;

    protected $presenterAdmin = 'App\Presenters\Admin\ArticlePresenter';

    protected $fillable = [
        'published',
        'content',
        'title',
        'date',
        'copy',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $nullable = [];

    public $checkboxes = ['published'];

    public $dates = ['date'];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'square' => [
                [
                    'name' => 'square',
                    'ratio' => 1,
                ],
            ],
        ],
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'article_category');
    }

    public function exhibitions()
    {
        return $this->belongsToMany('App\Models\Exhibition', 'article_exhibition')->withPivot('position')->orderBy('position');
    }

    public function artists()
    {
        return $this->belongsToMany('App\Models\Artist', 'article_artist')->withPivot('position')->orderBy('position');
    }

    public function selections()
    {
        return $this->belongsToMany('App\Models\Selection')->withPivot('position')->orderBy('position');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article', 'article_article', 'article_id', 'related_article_id')->withPivot('position')->orderBy('position');
    }
}

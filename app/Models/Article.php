<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;

class Article extends Model
{
    use HasSlug, HasRevisions, HasMedias, HasBlocks, Transformable;

    protected $presenterAdmin = 'App\Presenters\Admin\ArticlePresenter';

    protected $fillable = [
        'published',
        'date',
        'content',
        'title',
        'heading',
        'author',
        'copy',
        'type',
        'citation',
        'layout_type'
    ];

    public $slugAttributes = [
        'title',
    ];

    public static $articleLayouts = [
        0 => 'Basic',
        1 => 'Large Feature',
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
        'author' => [
            'square' => [
                [
                    'name' => 'square',
                    'ratio' => 1,
                ],
            ]
        ]
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'article_category');
    }

    public function selections()
    {
        return $this->belongsToMany('App\Models\Selection')->withPivot('position')->orderBy('position');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article', 'article_article', 'article_id', 'related_article_id')->withPivot('position')->orderBy('position');
    }

    public function apiElements()
    {
        return $this->morphToMany(\App\Models\ApiRelation::class, 'api_relatable')->withPivot(['position', 'relation'])->orderBy('position');
    }

    public function artworks()
    {
        return $this->apiElements()->where('relation', 'artworks');
    }

    public function exhibitions()
    {
        return $this->apiElements()->where('relation', 'exhibitions');
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'published',
                "doc" => "Published",
                "type" => "boolean",
                "value" => function() { return $this->published; }
            ],
            [
                "name" => 'date',
                "doc" => "Date",
                "type" => "date",
                "value" => function() { return $this->date; }
            ],
            [
                "name" => 'copy',
                "doc" => "Copy",
                "type" => "text",
                "value" => function() { return $this->copy; }
            ],
            
        ];
    }
}

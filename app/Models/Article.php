<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;
use App\Models\Behaviors\HasMediasEloquent;

class Article extends Model
{
    use HasSlug, HasRevisions, HasMedias, HasMediasEloquent, HasBlocks, Transformable;

    protected $presenter = 'App\Presenters\Admin\ArticlePresenter';
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
        'layout_type',
        'is_boosted',
    ];

    public $slugAttributes = [
        'title',
    ];

    const BASIC = 0;
    const LARGE = 1;

    public static $articleLayouts = [
        self::BASIC => 'Basic',
        self::LARGE => 'Large Feature',
    ];

    public $nullable = [];

    public $checkboxes = ['published', 'is_boosted'];

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

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'slug';
    }

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
                "value" => function() { return $this->blocks; }
            ],
            [
                "name" => 'is_boosted',
                "doc" => "Is Boosted",
                "type" => "boolean",
                "value" => function() { return $this->is_boosted; }
            ],
            [
                "name" => "slug",
                "doc" => "slug",
                "type" => "string",
                "value" => function () {return $this->slug;},
            ],
            [
                "name" => "web_url",
                "doc" => "web_url",
                "type" => "string",
                "value" => function () {return url(route('articles.show', $this));},
            ],
            [
                "name" => "type",
                "doc" => "type",
                "type" => "string",
                "value" => function () {return $this->type;},
            ],
            [
                "name" => "heading",
                "doc" => "heading",
                "type" => "string",
                "value" => function () {return $this->heading;},
            ],
            [
                "name" => "author",
                "doc" => "author",
                "type" => "string",
                "value" => function () {return $this->author;},
            ],
        ];
    }
}

<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;
use App\Models\Admission as Admission;
use App\Models\Behaviors\HasApiRelations;

class Page extends Model
{
    use HasSlug, HasRevisions, HasMedias, HasApiRelations, Transformable;

    public static $types = [
        0 => 'Home',
        1 => 'Exhibitions and Events',
        2 => 'Art and Ideas',
        3 => 'Visit',
        4 => 'Articles',
        5 => 'Exhibition History'
    ];

    protected $fillable = [
        'published',
        'position',
        'type',
        'title',

        // Homepage
        'home_intro',

        // Exhibition
        'exhibition_intro',

        // Exhibition History
        'exhibition_history_sub_heading',
        'exhibition_history_intro_copy',
        'exhibition_history_popup_copy',

        // Art and Ideas
        'art_intro',

        // Visit
        'visit_intro',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published'];

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
        'exhibition_history_intro' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ]
        ],
    ];

    public function scopeForType($query, $type) {
        return $query->where('type', array_flip(self::$types)[$type]);
    }

    public function homeExhibitions()
    {
        return $this->apiElements()->where('relation', 'homeExhibitions');
    }

    public function exhibitionsExhibitions()
    {
        return $this->apiElements()->where('relation', 'exhibitionsExhibitions');
    }

    public function exhibitionsCurrent()
    {
        return $this->apiElements()->where('relation', 'exhibitionsCurrent');
    }

    public function homeEvents()
    {
        return $this->belongsToMany('App\Models\Event', 'page_home_event')->withPivot('position')->orderBy('position');
    }

    public function homeShopItems()
    {
        return $this->apiElements()->where('relation', 'homeShopItems');
    }

    public function admissions()
    {
        return $this->hasMany(Admission::class)->orderBy('position');
    }

    public function locations()
    {
        return $this->hasMany(Location::class)->orderBy('position');
    }

    public function articlesArticles()
    {
        return $this->belongsToMany('App\Models\Article', 'page_article_article')->withPivot('position')->orderBy('position');
    }

    public function artArticles()
    {
        return $this->belongsToMany('App\Models\Article', 'page_art_article')->withPivot('position')->orderBy('position');
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'published',
                "doc" => "Published?",
                "type" => "boolean",
                "value" => function() { return $this->published; }
            ],

            [
                "name" => 'type',
                "doc" => "Type of Page",
                "type" => "integer",
                "value" => function() { return $this->type; }
            ],

            [
                "name" => 'home_intro',
                "doc" => "Home Intro",
                "type" => "string",
                "value" => function() { return $this->home_intro; }
            ],

            [
                "name" => 'exhibition_intro',
                "doc" => "Exhibition Intro",
                "type" => "string",
                "value" => function() { return $this->exhibition_intro; }
            ],

            [
                "name" => 'art_intro',
                "doc" => "Art Intro",
                "type" => "string",
                "value" => function() { return $this->art_intro; }
            ],

            [
                "name" => 'visit_intro',
                "doc" => "Visit Intro",
                "type" => "string",
                "value" => function() { return $this->visit_intro; }
            ],

        ];
    }
}

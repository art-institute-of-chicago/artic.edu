<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;
use App\Models\Admission as Admission;

class Page extends Model
{
    use HasSlug, HasRevisions, HasMedias;

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
    ];

    public function scopeForType($query, $type) {
        return $query->where('type', array_flip(self::$types)[$type]);
    }

    public function apiElements()
    {
        return $this->morphToMany(\App\Models\ApiRelation::class, 'api_relatable')->withPivot(['position', 'relation'])->orderBy('position');
    }

    public function homeExhibitions()
    {
        return $this->apiElements()->where('relation', 'homeExhibitions');
    }

    public function exhibitionsExhibitions()
    {
        return $this->apiElements()->where('relation', 'exhibitionsExhibitions');
    }

    public function homeEvents()
    {
        return $this->belongsToMany('App\Models\Event', 'page_home_event')->withPivot('position')->orderBy('position');
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
}

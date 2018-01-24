<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;

class Event extends Model
{
    use HasSlug, HasRevisions, HasMedias, HasBlocks;

    protected $presenterAdmin = 'App\Presenters\Admin\EventPresenter';

    protected $fillable = [
        'title',
        'published',
        'type',
        'short_description',
        'description',
        'hero_caption',
        'is_private',
        'is_after_hours',
        'is_ticketed',
        'is_free',
        'rsvp_link',
        'start_date',
        'end_date',

        'location',

        'landing',
        'content',
    ];

    public static $eventTypes = [
        0 => 'Classes and workshops',
        1 => 'Live arts',
        2 => 'Screenings',
        3 => 'Special Events',
        4 => 'Talks',
        5 => 'Tours',
        6 => 'Member Exclusive'
    ];

    public $slugAttributes = [
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = ['published', 'is_private', 'is_after_hours', 'is_ticketed', 'is_free'];

    public $dates = ['start_date', 'end_date'];

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

    public function siteTags()
    {
        return $this->morphToMany(\App\Models\SiteTag::class, 'site_taggable', 'site_tagged');
    }

    public function scopeLanding($query)
    {
        return $query->whereLanding(true);
    }
}

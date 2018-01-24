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
        'hidden',
        'rsvp_link',
        'start_date',
        'end_date',
        'location',
        'sponsors_description',
        'sponsors_sub_copy',
        'content',
        'layout_type',
        'buy_button_text',
        'buy_button_caption'
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

    public static $eventLayouts = [
        0 => 'Basic',
        1 => 'Large Feature',
    ];

    public $slugAttributes = [
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = ['published', 'is_private', 'is_after_hours', 'is_ticketed', 'is_free', 'hidden'];

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

    public function sponsors()
    {
        return $this->belongsToMany(\App\Models\Sponsor::class)->withPivot('position')->orderBy('position');
    }

    public function scopeLanding($query)
    {
        return $query->whereLanding(true);
    }

    public function events()
    {
        return $this->belongsToMany(\App\Models\Event::class, 'event_event', 'event_id', 'related_event_id')->withPivot('position')->orderBy('position');
    }
}

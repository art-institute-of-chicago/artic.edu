<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;
use App\Models\Behaviors\HasRecurrentDates;

class Event extends Model
{
    use HasSlug, HasRevisions, HasMedias, HasBlocks, HasRecurrentDates, Transformable;

    protected $presenterAdmin = 'App\Presenters\Admin\EventPresenter';
    protected $presenter = 'App\Presenters\Admin\EventPresenter';

    protected $appends = ['all_dates', 'date', 'date_end'];

    protected $fillable = [
        'title',
        'published',
        'type',
        'short_description',
        'description',
        'hero_caption',
        'start_time',
        'end_time',
        'is_private',
        'is_after_hours',
        'is_ticketed',
        'is_sold_out',
        'is_free',
        'is_boosted',
        'is_ongoing',
        'is_member_exclusive',
        'hidden',
        'rsvp_link',
        'location',
        'sponsors_description',
        'sponsors_sub_copy',
        'content',
        'layout_type',
        'buy_button_text',
        'buy_button_caption'
    ];

    const CLASSES_AND_WORKSHOPS = 0;
    const LIVE_ARTS = 1;
    const SCREENINGS = 2;
    const SPECIAL_EVENT = 3;
    const TALKS = 4;
    const TOUR = 5;

    public static $eventTypes = [
        self::CLASSES_AND_WORKSHOPS => 'Classes and workshops',
        self::LIVE_ARTS => 'Live arts',
        self::SCREENINGS => 'Screenings',
        self::SPECIAL_EVENT => 'Special Event',
        self::TALKS => 'Talks',
        self::TOUR => 'Tour'
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
    public $checkboxes = [
        'published',
        'hidden',
        'is_private',
        'is_after_hours',
        'is_ticketed',
        'is_free',
        'is_member_exclusive',
        'is_ongoing',
        'is_sold_out',
        'is_boosted'
    ];

    public $dates = ['date', 'date_end'];

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

    // Generates the id-slug type of URL
    public function getRouteKeyName() {
        return 'id_slug';
    }

    public function getIdSlugAttribute() {
        return join([$this->id, $this->getSlug()], '-');
    }

    public function getTimeStartAttribute() {
        if ($this->date)
            return $this->date->format('h:ia');
    }

    public function getTimeEndAttribute() {
        if ($this->date_end)
         return $this->date_end->format('h:ia');
    }

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

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => "title",
                "doc" => "Title",
                "type" => "boolean",
                "value" => function() { return $this->title; }
            ],
                    [
                "name" => "published",
                "doc" => "Published",
                "type" => "boolean",
                "value" => function() { return $this->published; }
            ],
                    [
                "name" => "type",
                "doc" => "Type",
                "type" => "number",
                "value" => function() { return $this->type; }
            ],
                    [
                "name" => "short_description",
                "doc" => "Short Description",
                "type" => "string",
                "value" => function() { return $this->short_description; }
            ],
                    [
                "name" => "description",
                "doc" => "Description",
                "type" => "string",
                "value" => function() { return $this->description; }
            ],
                    [
                "name" => "hero_caption",
                "doc" => "Hero caption",
                "type" => "string",
                "value" => function() { return $this->hero_caption; }
            ],
                    [
                "name" => "is_private",
                "doc" => "Is Private",
                "type" => "boolean",
                "value" => function() { return $this->is_private; }
            ],
                    [
                "name" => "is_after_hours",
                "doc" => "Is after hhours",
                "type" => "boolean",
                "value" => function() { return $this->is_after_hours; }
            ],
                    [
                "name" => "is_ticketed",
                "doc" => "Is ticketed",
                "type" => "boolean",
                "value" => function() { return $this->is_ticketed; }
            ],
                    [
                "name" => "is_free",
                "doc" => "Is Free",
                "type" => "boolean",
                "value" => function() { return $this->is_free; }
            ],
                    [
                "name" => "is_member_exclusive",
                "doc" => "Is member exclusive",
                "type" => "boolean",
                "value" => function() { return $this->is_member_exclusive; }
            ],
                    [
                "name" => "hidden",
                "doc" => "Hidden",
                "type" => "boolean",
                "value" => function() { return $this->hidden; }
            ],
            [
                "name" => "rsvp_link",
                "doc" => "RSVP Link",
                "type" => "string",
                "value" => function() { return $this->rsvp_link; }
            ],
            [
                "name" => "all_dates",
                "doc" => "Dates",
                "type" => "array",
                "value" => function() { return $this->all_dates; }
            ],
            [
                "name" => "location",
                "doc" => "Location",
                "type" => "string",
                "value" => function() { return $this->location; }
            ],
                    [
                "name" => "sponsors_description",
                "doc" => "sponsors_description",
                "type" => "string",
                "value" => function() { return $this->sponsors_description; }
            ],
                    [
                "name" => "sponsors_sub_copy",
                "doc" => "sponsors_sub_copy",
                "type" => "string",
                "value" => function() { return $this->sponsors_sub_copy; }
            ],
                    [
                "name" => "content",
                "doc" => "Content",
                "type" => "string",
                "value" => function() { return $this->content; }
            ],
                    [
                "name" => "layout_type",
                "doc" => "Layout Type",
                "type" => "number",
                "value" => function() { return $this->layout_type; }
            ],
            [
                "name" => "buy_button_text",
                "doc" => "buy_button_text",
                "type" => "string",
                "value" => function() { return $this->buy_button_text; }
            ],
                    [
                "name" => "buy_button_caption",
                "doc" => "buy_button_caption",
                "type" => "string",
                "value" => function() { return $this->buy_button_caption; }
            ]
        ];
    }
}

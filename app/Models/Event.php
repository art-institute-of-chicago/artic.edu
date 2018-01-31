<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;

class Event extends Model
{
    use HasSlug, HasRevisions, HasMedias, HasBlocks, Transformable;

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
        'is_member_exclusive',
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
        5 => 'Tours'
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
        'published', 'is_private', 'is_after_hours',
        'is_ticketed', 'is_free', 'hidden', 'is_member_exclusive'];

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
                "doc" => "RSVP ink",
                "type" => "string",
                "value" => function() { return $this->rsvp_link; }
            ],
            [
                "name" => "start_date",
                "doc" => "start_date",
                "type" => "date",
                "value" => function() { return $this->start_date; }
            ],
                    [
                "name" => "end_date",
                "doc" => "end_date",
                "type" => "date",
                "value" => function() { return $this->end_date; }
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

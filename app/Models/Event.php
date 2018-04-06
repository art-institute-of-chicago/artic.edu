<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;
use App\Models\Behaviors\HasRecurrentDates;
use Carbon\Carbon;
use App\Models\Behaviors\HasMediasEloquent;

class Event extends Model
{
    use HasSlug, HasRevisions, HasMedias, HasMediasEloquent, HasBlocks, HasRecurrentDates, Transformable;

    protected $presenterAdmin = 'App\Presenters\Admin\EventPresenter';
    protected $presenter = 'App\Presenters\Admin\EventPresenter';

    protected $appends = ['all_dates', 'all_dates_cms'];

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdateEvent::class,
        'deleted' => \App\Events\UpdateEvent::class
    ];

    protected $fillable = [
        'title',
        'published',
        'type',
        'audience',
        'short_description',
        'list_description',
        'description',
        'hero_caption',
        'forced_date',
        'start_time',
        'end_time',
        'is_private',
        'is_after_hours',
        'is_ticketed',
        'is_sold_out',
        'is_free',
        'is_boosted',
        'is_member_exclusive',
        'hidden',
        'rsvp_link',
        'buy_tickets_link',
        'location',
        'sponsors_description',
        'sponsors_sub_copy',
        'content',
        'layout_type',
        'buy_button_text',
        'buy_button_caption',
        'migrated_node_id',
    ];

    const CLASSES_AND_WORKSHOPS = 1;
    const LIVE_ARTS = 2;
    const SCREENINGS = 3;
    const SPECIAL_EVENT = 4;
    const TALKS = 5;
    const TOUR = 6;

    public static $eventTypes = [
        self::CLASSES_AND_WORKSHOPS => 'Classes and workshops',
        self::LIVE_ARTS => 'Live arts',
        self::SCREENINGS => 'Screenings',
        self::SPECIAL_EVENT => 'Special Event',
        self::TALKS => 'Talks',
        self::TOUR => 'Tour',
    ];

    const FAMILIES = 1;
    const MEMBERS = 2;
    const ADULTS = 3;
    const TEENS = 4;
    const RESEARCHERS_SCHOLARS = 5;
    const TEACHERS = 6;
    const EVENING_ASSOCIATES = 7;

    public static $eventAudiences = [
        self::FAMILIES => 'Families',
        self::MEMBERS => 'Members',
        self::ADULTS => 'Adults',
        self::TEENS => 'Teens',
        self::RESEARCHERS_SCHOLARS => 'Researchers/Scholars',
        self::TEACHERS => 'Teachers',
        self::EVENING_ASSOCIATES => 'Evening Associates',
    ];

    const BASIC_LAYOUT = 0;
    const LARGE_LAYOUT = 1;

    public static $eventLayouts = [
        self::BASIC_LAYOUT => 'Basic',
        self::LARGE_LAYOUT => 'Large Feature',
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
        'is_sold_out',
        'is_boosted',
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
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join([$this->id, $this->getSlug()], '-');
    }

    public function getUrlWithoutSlugAttribute()
    {
        return join([route('events'), '/', $this->id, '-']);
    }

    public function getTimeStartAttribute()
    {
        if ($this->date) {
            return $this->date->format('h:ia');
        }

    }

    public function getTimeEndAttribute()
    {
        if ($this->date_end) {
            return $this->date_end->format('h:ia');
        }

    }

    public function getAllDatesCmsAttribute()
    {
        $dates_string = '';
        foreach($this->all_dates as $date) {
            $dates_string .= $date['date']->format('F j, Y h:ia') . ' - ' . $date['date_end']->format('F j, Y h:ia') . "\n";
        }

        return $dates_string;
    }

    public function sponsors()
    {
        return $this->belongsToMany(\App\Models\Sponsor::class)->withPivot('position')->orderBy('position');
    }

    public function scopeLanding($query)
    {
        return $query->whereLanding(true);
    }

    public function scopeNotHidden($query)
    {
        return $query->whereHidden(false);
    }

    public function scopeBetweenDates($query, $startDate, $endDate = null)
    {
        $query->rightJoin('event_metas', function ($join) {
            $join->on('events.id', '=', 'event_metas.event_id');
        });
        $query->where('event_metas.date', '>=', $startDate);

        if ($endDate) {
            $query->where('event_metas.date_end', '<=', $endDate);
        }

        $query->orderBy('event_metas.date', 'ASC');

        return $query;
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', '=', $type);
    }

    public function scopeByAudience($query, $audience)
    {
        return $query->where('audience', '=', $audience);
    }

    public function scopeToday($query)
    {
        return $query->betweenDates(Carbon::today(), Carbon::tomorrow());
    }

    public function scopeTomorrow($query)
    {
        return $query->betweenDates(Carbon::tomorrow(), Carbon::tomorrow()->addDay());
    }

    public function scopeWeekend($query)
    {
        return $query->betweenDates(Carbon::today()->nextWeekendDay(), Carbon::today()->nextWeekendDay()->addDays(2));
    }

    public static function groupByDay($collection)
    {
        return $collection->groupBy(function($item) {
          return $item->date->format('Y-m-d');
        });
    }

    public function events()
    {
        return $this->belongsToMany(\App\Models\Event::class, 'event_event', 'event_id', 'related_event_id')->withPivot('position')->orderBy('position');
    }

    public function getNextOcurrenceAttribute()
    {
        return $this->eventMetas()->where('date', '>=', Carbon::now())->orderBy('date', 'ASC')->first();
    }

    public function getAudienceDisplay()
    {
        $display = '';

        if ($this->audience != null) {
            $display = self::$eventAudiences[$this->audience];
        }

        return $display;
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => "title",
                "doc" => "Title",
                "type" => "boolean",
                "value" => function () {return $this->title;},
            ],
            [
                "name" => "published",
                "doc" => "Published",
                "type" => "boolean",
                "value" => function () {return $this->published;},
            ],
            [
                "name" => "type",
                "doc" => "Type",
                "type" => "number",
                "value" => function () {return $this->type;},
            ],
            [
                "name" => "short_description",
                "doc" => "Short Description",
                "type" => "string",
                "value" => function () {return $this->short_description;},
            ],
            [
                "name" => "description",
                "doc" => "Description",
                "type" => "string",
                "value" => function () {return $this->description;},
            ],
            [
                "name" => "list_description",
                "doc" => "list_description",
                "type" => "string",
                "value" => function () {return $this->list_description;},
            ],
            [
                "name" => "hero_caption",
                "doc" => "Hero caption",
                "type" => "string",
                "value" => function () {return $this->hero_caption;},
            ],
            [
                "name" => "is_private",
                "doc" => "Is Private",
                "type" => "boolean",
                "value" => function () {return $this->is_private;},
            ],
            [
                "name" => "is_after_hours",
                "doc" => "Is after hhours",
                "type" => "boolean",
                "value" => function () {return $this->is_after_hours;},
            ],
            [
                "name" => "is_ticketed",
                "doc" => "Is ticketed",
                "type" => "boolean",
                "value" => function () {return $this->is_ticketed;},
            ],
            [
                "name" => "is_free",
                "doc" => "Is Free",
                "type" => "boolean",
                "value" => function () {return $this->is_free;},
            ],
            [
                "name" => "is_member_exclusive",
                "doc" => "Is member exclusive",
                "type" => "boolean",
                "value" => function () {return $this->is_member_exclusive;},
            ],
            [
                "name" => "hidden",
                "doc" => "Hidden",
                "type" => "boolean",
                "value" => function () {return $this->hidden;},
            ],
            [
                "name" => "rsvp_link",
                "doc" => "RSVP Link",
                "type" => "string",
                "value" => function () {return $this->rsvp_link;},
            ],
            [
                "name" => "all_dates",
                "doc" => "Dates",
                "type" => "array",
                "value" => function () {return $this->all_dates;},
            ],
            [
                "name" => "location",
                "doc" => "Location",
                "type" => "string",
                "value" => function () {return $this->location;},
            ],
            [
                "name" => "audience",
                "doc" => "Audience",
                "type" => "string",
                "value" => function () {return $this->getAudienceDisplay();},
            ],
            [
                "name" => "sponsors_description",
                "doc" => "sponsors_description",
                "type" => "string",
                "value" => function () {return $this->sponsors_description;},
            ],
            [
                "name" => "sponsors_sub_copy",
                "doc" => "sponsors_sub_copy",
                "type" => "string",
                "value" => function () {return $this->sponsors_sub_copy;},
            ],
            [
                "name" => "content",
                "doc" => "Content",
                "type" => "string",
                "value" => function () {return $this->content;},
            ],
            [
                "name" => "layout_type",
                "doc" => "Layout Type",
                "type" => "number",
                "value" => function () {return $this->layout_type;},
            ],
            [
                "name" => "buy_button_text",
                "doc" => "buy_button_text",
                "type" => "string",
                "value" => function () {return $this->buy_button_text;},
            ],
            [
                "name" => "buy_button_caption",
                "doc" => "buy_button_caption",
                "type" => "string",
                "value" => function () {return $this->buy_button_caption;},
            ],
            [
                "name" => "forced_date",
                "doc" => "forced_date",
                "type" => "string",
                "value" => function () {return $this->forced_date;},
            ],
            [
                "name" => "buy_tickets_link",
                "doc" => "buy_tickets_link",
                "type" => "string",
                "value" => function () {return $this->buy_tickets_link;},
            ],
            [
                "name" => "is_sold_out",
                "doc" => "is_sold_out",
                "type" => "boolean",
                "value" => function () {return $this->is_sold_out;},
            ],
            [
                "name" => "is_boosted",
                "doc" => "is_boosted",
                "type" => "boolean",
                "value" => function () {return $this->is_boosted;},
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
                "value" => function () {return url(route('events.show', $this));},
            ],
        ];
    }
}

<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Model;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRecurrentDates;
use Carbon\Carbon;
use App\Models\Behaviors\HasApiRelations;

// TODO: Use `whereJsonContains` in Laravel 5.7 - https://github.com/laravel/framework/pull/24330
use Illuminate\Support\Facades\DB;
use PDO;

class Event extends Model
{
    use HasSlug, HasRevisions, HasApiRelations, HasMedias, HasMediasEloquent, HasBlocks, HasRecurrentDates, Transformable;

    protected $presenterAdmin = 'App\Presenters\Admin\EventPresenter';
    protected $presenter = 'App\Presenters\Admin\EventPresenter';

    protected $appends = ['all_dates', 'all_dates_cms'];

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdateEvent::class,
        'deleted' => \App\Events\UpdateEvent::class,
    ];

    protected $fillable = [
        'title',
        'title_display',
        'published',
        'event_type',
        'alt_types',
        'audience',
        'alt_audiences',
        'short_description',
        'list_description',
        'description',
        'hero_caption',
        'forced_date',
        'start_time',
        'end_time',
        'door_time',
        'is_private',
        'is_after_hours',
        'is_ticketed',
        'is_sold_out',
        'is_free',
        'is_boosted',
        'is_member_exclusive',
        'is_registration_required',
        'is_admission_required',
        'survey_link',
        'email_series',
        'hidden',
        'rsvp_link',
        'buy_tickets_link',
        'location',
        'sponsors_description',
        'content',
        'layout_type',
        'buy_button_text',
        'buy_button_caption',
        'migrated_node_id',
        'migrated_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'alt_types' => 'array',
        'alt_audiences' => 'array',
    ];

    const CLASSES_AND_WORKSHOPS = 1;
    const LIVE_ARTS = 2;
    const SCREENINGS = 3;
    const SPECIAL_EVENT = 4;
    const TALKS = 5;
    const TOUR = 6;
    const COMMUNITIES = 7;

    public static $eventTypes = [
        self::CLASSES_AND_WORKSHOPS => 'Classes and Workshops',
        self::LIVE_ARTS => 'Live Arts',
        self::SCREENINGS => 'Screenings',
        self::SPECIAL_EVENT => 'Special Event',
        self::TALKS => 'Talks',
        self::TOUR => 'Tour',
        self::COMMUNITIES => 'Programs in Communities',
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
        'is_admission_required',
        'is_sold_out',
        'is_boosted',
        'is_registration_required'
    ];

    public $dates = ['date', 'date_end', 'migrated_at'];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
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
        return join([$this->id, $this->getSlug()], '/');
    }

    public function getUrlWithoutSlugAttribute()
    {
        return join([route('events'), '/', $this->id, '/']);
    }

    public function getTimeStartAttribute()
    {
        if ($this->date) {
            return $this->date->format('g:ia');
        }

    }

    public function getTimeEndAttribute()
    {
        if ($this->date_end) {
            return $this->date_end->format('g:ia');
        }

    }

    public function getTypeAttribute()
    {
        return 'event';
    }

    public function getAllDatesCmsAttribute()
    {
        $dates_string = '';
        foreach ($this->all_dates as $date) {

            $dates_string .= $date['date']->format('F j, Y g:i') . ' - ' . $date['date_end']->format('F j, Y g:i') . "\n";
        }

        return $dates_string;
    }

    public function getDateStartAttribute()
    {
        return $this->all_dates->first()['date'];
    }

    public function getDateEndAttribute()
    {
        return $this->all_dates->last()['date_end'];
    }

    public function getAltTypesAttribute($value)
    {
        return $this->getMultiSelectFromJsonColumn($value);
    }

    public function getAltAudiencesAttribute($value)
    {
        return $this->getMultiSelectFromJsonColumn($value);
    }

    public function setAltTypesAttribute($value)
    {
        $this->attributes['alt_types'] = $this->getJsonColumnFromMultiSelect($value);
    }

    public function setAltAudiencesAttribute($value)
    {
        $this->attributes['alt_audiences'] = $this->getJsonColumnFromMultiSelect($value);
    }

    public function getBuyTicketsLinkAttribute($value)
    {
        $ticketedEvent = $this->apiModels('ticketedEvent', 'TicketedEvent')->first();
        if ($ticketedEvent) {
            $date = $this->nextOcurrence->date ?? $this->lastOcurrence->date;
            return "https://sales.artic.edu/Events/Event/" .$ticketedEvent->id ."?date=" .$date->format('n/j/Y');
        }
        return $value;
    }

    // This emulates an Eloquent collection from a JSON column
    // TODO: Move this somewhere more appropriate - presenter?
    private function getMultiSelectFromJsonColumn($value)
    {
        return collect(json_decode($value))->map(function($item) { return ['id' => $item]; })->all();
    }

    // Without this, we get `null` values in array
    // TODO: Move this somewhere more appropriate - presenter?
    private function getJsonColumnFromMultiSelect($value)
    {
        return collect($value)->filter()->values();
    }

    public function sponsors()
    {
        return $this->belongsToMany(\App\Models\Sponsor::class)->withPivot('position')->orderBy('position');
    }

    public function ticketedEvent()
    {
        return $this->apiElements()->where('relation', 'ticketedEvent');
    }

    public function programs()
    {
        return $this->belongsToMany('App\Models\EventProgram');
    }

    public function getProgramUrlsAttribute()
    {
        return $this->programs->reduce(function($carry, $item) {
            return $carry .'https://' .config('app.url') .route('events', [], false) .'?program=' .$item->id ."\n";
        });
    }

    public function scopeLanding($query)
    {
        return $query->whereLanding(true);
    }

    public function scopeIds($query, $ids = [])
    {
        return $query->whereIn('id', $ids);
    }

    public function scopeNotHidden($query)
    {
        return $query->whereHidden(false);
    }

    public function scopeNotPrivate($query)
    {
        return $query->whereIsPrivate(false);
    }

    public function scopeBetweenDates($query, $startDate, $endDate = null)
    {
        $query->rightJoin('event_metas', function ($join) {
            $join->on('events.id', '=', 'event_metas.event_id');
        });
        $query->where('event_metas.date', '>=', $startDate);

        if ($endDate) {
            $query->where('event_metas.date_end', '<=', Carbon::parse($endDate)->endOfDay());
        }

        $query->orderBy('event_metas.date', 'ASC');

        return $query;
    }

    // NOTE: This works only while there are less than 10 possible type values
    // TODO: Use `whereJsonContains` in Laravel 5.7 - https://github.com/laravel/framework/pull/24330
    public function scopeByType($query, $type)
    {
        return $query->where('event_type', '=', $type)->orWhereRaw($this->getWhereJsonContainsRaw('alt_types', $type));
    }

    // NOTE: This works only while there are less than 10 possible audience values
    // TODO: Use `whereJsonContains` in Laravel 5.7 - https://github.com/laravel/framework/pull/24330
    public function scopeByAudience($query, $audience)
    {
        return $query->where('audience', '=', $audience)->orWhereRaw($this->getWhereJsonContainsRaw('alt_audiences', $audience));
    }

    public function scopeByProgram($query, $program = null)
    {
        if (empty($program)) {
            return $query;
        }

        return $query->whereHas('programs', function ($query) use ($program) {
            $query->where('event_program_id', $program);
        });
    }

    // Helper function to make `LIKE` on JSON column work correctly with both MySQL and PostgreSQL
    // TODO: Use `whereJsonContains` in Laravel 5.7 - https://github.com/laravel/framework/pull/24330
    private function getWhereJsonContainsRaw($field, $value)
    {
        if (DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'pgsql') {
            return $field ."::text LIKE '%" .$value ."%'";
        }

        return $field ." LIKE '%" .$value ."%'";
    }

    public function scopeDefault($query)
    {
        return $query->betweenDates(Carbon::today(), Carbon::today()->addDay(14));
    }

    public function scopeYear($query)
    {
        return $query->betweenDates(Carbon::today(), Carbon::today()->addYear());
    }

    public function scopeWeekend($query)
    {
        return $query->betweenDates(Carbon::today()->nextWeekendDay(), Carbon::today()->nextWeekendDay()->addDays(2));
    }

    public static function groupByDay($collection)
    {
        return $collection->groupBy(function ($item) {
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

    public function getLastOcurrenceAttribute()
    {
        return $this->eventMetas()->orderBy('date', 'DESC')->first();
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
                "name" => "event_type",
                "doc" => "Type",
                "type" => "number",
                "value" => function () {return $this->event_type;},
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
                "name" => "is_registration_required",
                "doc" => "Is Registration required",
                "type" => "boolean",
                "value" => function () {return $this->is_registration_required;},
            ],
            [
                "name" => "is_admission_required",
                "doc" => "Is admission required",
                "type" => "boolean",
                "value" => function () {return $this->is_admission_required;},
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
                "name" => "start_time",
                "doc" => "Start Time",
                "type" => "string",
                "value" => function () {return $this->start_time;},
            ],
            [
                "name" => "end_time",
                "doc" => "End Time",
                "type" => "string",
                "value" => function () {return $this->end_time;},
            ],
            [
                "name" => "start_date",
                "doc" => "Date the event begins",
                "type" => "string",
                "value" => function () {return $this->date_start ? $this->date_start->toIso8601String() : null;},
            ],
            [
                "name" => "end_date",
                "doc" => "Date the event ends",
                "type" => "string",
                "value" => function () {return $this->date_end ? $this->date_end->toIso8601String() : null;},
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
                "value" => function () {return $this->audience;},
            ],
            [
                "name" => "sponsors_description",
                "doc" => "sponsors_description",
                "type" => "string",
                "value" => function () {return $this->sponsors_description;},
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
                "name" => "ticketed_event_id",
                "doc" => "Unique identifer of the event in our central ticketing system",
                "type" => "string",
                "value" => function () {
                    $ticketedEvent = $this->apiModels('ticketedEvent', 'TicketedEvent')->first();
                    return $ticketedEvent ? $ticketedEvent->id : null;
                },
            ],
            [
                "name" => "survey_url",
                "doc" => "URL to the survey associated with this event",
                "type" => "string",
                "value" => function () {return $this->survey_link;},
            ],
            [
                "name" => "email_series",
                "doc" => "Email series",
                "type" => "string",
                "value" => function () {return $this->email_series;},
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
                "name" => "door_time",
                "doc" => "door_time",
                "type" => "string",
                "value" => function () {return $this->door_time ? \Carbon\CarbonInterval::create($this->door_time)->format('%H:%i') : null;},
            ],
            [
                "name" => "web_url",
                "doc" => "web_url",
                "type" => "string",
                "value" => function () {return url(route('events.show', $this));},
            ],
        ];
    }

    /**
     * Validate an id. Useful for validating routes or query string params.
     *
     * By default, only numeric ids greater than zero are accepted. Override this
     * method in child classes to implement different validation rules (e.g. UUID).
     *
     * @param mixed $id
     * @return boolean
     */
    public static function validateId( $id )
    {
        // By default, only allow numeric ids greater than 0
        return is_numeric($id) && intval($id) > 0;
    }

}

<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRecurrentDates;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasFeaturedRelated;
use App\Models\Behaviors\HasAutoRelated;
use App\Helpers\QueryHelpers;
use App\Models\Behaviors\HasRelated;
use Carbon\Carbon;
// WEB-2260: Use `whereJsonContains` in Laravel 5.7 - https://github.com/laravel/framework/pull/24330
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use PDO;

class Event extends AbstractModel
{
    use HasSlug;
    use HasRevisions;
    use HasApiRelations;
    use HasAutoRelated;
    use HasFeaturedRelated;
    use HasRelated;
    use HasMedias;
    use HasMediasEloquent;
    use HasBlocks;
    use HasRecurrentDates;
    use Transformable;
    use HasFactory;

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
        'is_sales_button_hidden',
        'is_after_hours',
        'is_virtual_event',
        'virtual_event_url',
        'virtual_event_passcode',
        'is_ticketed',
        'is_sold_out',
        'is_free',
        'is_rsvp',
        'is_member_exclusive',
        'is_registration_required',
        'is_admission_required',
        'survey_link',
        'email_series',
        'rsvp_link',
        'location',
        'content',
        'layout_type',
        'buy_button_text',
        'buy_button_caption',
        'migrated_node_id',
        'migrated_at',
        'meta_title',
        'meta_description',
        'search_tags',
        'add_to_event_email_series',
        'join_url',
        'survey_url',
        'event_host_id',
        'entrance',
        'test_emails',
        'publish_start_date',
        'publish_end_date',
        'toggle_autorelated',
    ];

    protected $casts = [
        'alt_types' => 'array',
        'alt_audiences' => 'array',
        'date' => 'date',
        'date_end' => 'date',
        'migrated_at' => 'datetime',
        'publish_start_date' => 'date',
        'publish_end_date' => 'date',
        'published' => 'boolean',
        'is_private' => 'boolean',
        'is_sales_button_hidden' => 'boolean',
        'is_after_hours' => 'boolean',
        'is_ticketed' => 'boolean',
        'is_free' => 'boolean',
        'is_rsvp' => 'boolean',
        'is_member_exclusive' => 'boolean',
        'is_admission_required' => 'boolean',
        'is_sold_out' => 'boolean',
        'is_registration_required' => 'boolean',
        'toggle_autorelated' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
        'is_private' => false,
        'is_sales_button_hidden' => false,
        'is_after_hours' => false,
        'is_ticketed' => false,
        'is_free' => false,
        'is_rsvp' => false,
        'is_member_exclusive' => false,
        'is_admission_required' => false,
        'is_sold_out' => false,
        'is_registration_required' => false,
        'toggle_autorelated' => false,
    ];

    /**
     * Dropdown does not accept null keys; use big numbers
     */
    public const NULL_OPTION = 42;
    public const NULL_OPTION_AFFILIATE_GROUP = 1024;
    public const NULL_OPTION_EVENT_HOST = 1024;

    public const CLASSES_AND_WORKSHOPS = 1;
    // const LIVE_ARTS = 2;
    public const SCREENINGS = 3;
    public const SPECIAL_EVENT = 4;
    public const TALKS = 5;
    public const TOUR = 6;
    // const COMMUNITIES = 7;

    public static $eventTypes = [
        self::CLASSES_AND_WORKSHOPS => 'Class/Workshop',
        self::TALKS => 'Talk',
        self::TOUR => 'Tour',
        self::SCREENINGS => 'Screening',
        self::SPECIAL_EVENT => 'Special Event',
        // self::LIVE_ARTS => 'Live Arts',
        // self::COMMUNITIES => 'Programs in Communities',
    ];

    public const FAMILIES = 1;
    public const MEMBERS = 2;
    public const ADULTS = 3;
    public const TEENS = 4;
    public const RESEARCHERS_SCHOLARS = 5;
    public const TEACHERS = 6;
    public const LUMINARY = 8;

    public static $eventAudiences = [
        self::ADULTS => 'General Public',
        self::MEMBERS => 'Members',
        self::LUMINARY => 'Luminary',
        self::FAMILIES => 'Families',
        self::TEENS => 'Teens',
        self::TEACHERS => 'Educators',
        self::RESEARCHERS_SCHOLARS => 'Researchers/Scholars',
    ];

    public const BASIC_LAYOUT = 0;
    public const LARGE_LAYOUT = 1;

    public static $eventLayouts = [
        self::BASIC_LAYOUT => 'Basic',
        self::LARGE_LAYOUT => 'Large Feature',
    ];

    public const MICHIGAN_AVE = 1;
    public const MODERN_WING = 2;
    public const COLUMBUS_DRIVE = 3;
    public const NORTH_GARDEN = 4;
    public const PRITZKER_GARDEN = 5;
    public const SOUTH_GARDEN = 6;
    public const OFF_SITE = 7;
    public const WEST_BOX = 8;

    public static $eventEntrances = [
        self::MICHIGAN_AVE => 'Michigan Avenue',
        self::MODERN_WING => 'Modern Wing',
        self::COLUMBUS_DRIVE => 'Columbus Drive',
        self::NORTH_GARDEN => 'North Garden',
        self::PRITZKER_GARDEN => 'Pritzker Garden',
        self::SOUTH_GARDEN => 'South Garden',
        self::OFF_SITE => 'Off Site',
        self::WEST_BOX => 'West Box',
    ];

    public $slugAttributes = [
        'title',
    ];

    /**
     * Those fields get auto set to null if not submitted
     */
    public $nullable = [];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
        'mobile_hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 1,
                ],
            ],
        ],
    ];

    public function emailSeries()
    {
        return $this
            ->belongsToMany('App\Models\EmailSeries', 'event_email_series')
            ->using('App\Models\EventEmailSeries')
            ->withPivot(
                'send_affiliate_test',
                'send_member_test',
                'send_luminary_test',
                'send_nonmember_test',
                'override_affiliate',
                'override_member',
                'override_luminary',
                'override_nonmember',
                'affiliate_copy',
                'member_copy',
                'luminary_copy',
                'nonmember_copy'
            );
    }

    /**
     * Generates the id-slug type of URL
     */
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join('/', [$this->id, $this->getSlug()]);
    }

    public function getUrlWithoutSlugAttribute()
    {
        return join([route('events'), '/', $this->id, '/']);
    }

    public function getAdminEditUrlAttribute()
    {
        return route('admin.exhibitions_events.events.edit', $this->id);
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
        $firstDate = $this->all_dates->last();

        if (empty($firstDate)) {
            return;
        }

        return $firstDate['date'];
    }

    public function getDateEndAttribute()
    {
        $lastDate = $this->all_dates->first();

        if (empty($lastDate)) {
            return;
        }

        return $lastDate['date_end'];
    }

    public function getDateEndTimeAttribute()
    {
        return $this->date->setTime($this->date_end->hour, $this->date_end->minute, $this->date_end->second);
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
        if ($this->rsvp_link) {
            return $this->rsvp_link;
        }
        $ticketedEvent = $this->apiModels('ticketedEvent', 'TicketedEvent')->first();

        if ($ticketedEvent) {
            $date = $this->nextOccurrence->date ?? $this->lastOccurrence->date ?? null;

            return 'https://sales.artic.edu/Events/Event/' . $ticketedEvent->id . ($date ? '?date=' . $date->format('n/j/Y') : '');
        }

        return $value;
    }

    /**
     * This emulates an Eloquent collection from a JSON column
     *
     * @see WEB-2261: Move this somewhere more appropriate - presenter?
     */
    private function getMultiSelectFromJsonColumn($value)
    {
        return collect(json_decode($value))->map(function ($item) {
            return ['id' => $item];
        })->all();
    }

    /**
     * Without this, we get `null` values in array
     * @see WEB-2261: Move this somewhere more appropriate - presenter?
     */
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

    public function affiliateGroup()
    {
        return $this->belongsTo('App\Models\EventProgram', 'affiliate_group_id');
    }

    public function eventHost()
    {
        return $this->belongsTo('App\Models\EventProgram', 'event_host_id');
    }

    public function getProgramUrlsAttribute()
    {
        return $this->programs->reduce(function ($carry, $item) {
            return $carry . 'https://' . config('app.url') . route('events', [], false) . '?program=' . $item->id . "\n";
        });
    }

    public function scopeToday($query)
    {
        $today = Carbon::today();

        return $query->betweenDates($today, $today->copy()->endOfDay());
    }


    public function scopeLanding($query)
    {
        return $query->whereLanding(true);
    }

    public function scopeIds($query, $ids = [])
    {
        return $query->whereIn('id', $ids);
    }

    public function scopeNotPrivate($query)
    {
        return $query->whereIsPrivate(false);
    }

    public function scopeFuture($query)
    {
        return $query->whereHas('eventMetas', function ($query) {
            $query->where('date_end', '>=', Carbon::now());
        });
    }

    public function getIsFutureAttribute()
    {
        return self::future()->find($this->id) != null;
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

    /**
     * NOTE: This works only while there are less than 10 possible type values
     *
     * @see WEB-2260: Use `whereJsonContains` in Laravel 5.7 - https://github.com/laravel/framework/pull/24330
     */
    public function scopeByType($query, $types)
    {
        collect($types)->map(function ($type) {
            return (int) $type;
        })->filter(function ($type) {
            return array_key_exists($type, self::$eventTypes);
        })->each(function ($type) use ($query) {
            $query->where('event_type', '=', $type)
                ->orWhereRaw($this->getWhereJsonContainsRaw('alt_types', $type));
        });

        return $query;
    }

    /**
     * NOTE: This works only while there are less than 10 possible audience values
     * @see WEB-2260: Use `whereJsonContains` in Laravel 5.7 - https://github.com/laravel/framework/pull/24330
     */
    public function scopeByAudience($query, $audiences)
    {
        collect($audiences)->map(function ($audience) {
            return (int) $audience;
        })->filter(function ($audience) {
            return array_key_exists($audience, self::$eventAudiences);
        })->each(function ($audience) use ($query) {
            $query->where('audience', '=', $audience)
                ->orWhereRaw($this->getWhereJsonContainsRaw('alt_audiences', $audience));
        });

        return $query;
    }

    public function scopeByProgram($query, $programs = null)
    {
        if (empty($programs)) {
            return $query;
        }

        $programs = collect($programs)->map(function ($program) {
            return (int) $program;
        })->all();

        return $query->whereHas('programs', function ($query) use ($programs) {
            $query->whereIn('event_program_id', $programs);
        });
    }

    /**
     * Helper function to make `LIKE` on JSON column work correctly with both MySQL and PostgreSQL
     *
     * @see WEB-2260: Use `whereJsonContains` in Laravel 5.7 - https://github.com/laravel/framework/pull/24330
     */
    private function getWhereJsonContainsRaw($field, $value)
    {
        if (DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'pgsql') {
            return $field . "::text LIKE '%" . QueryHelpers::escape_like($value) . "%'";
        }

        return $field . " LIKE '%" . QueryHelpers::escape_like($value) . "%'";
    }

    public function setEventTypeAttribute($value)
    {
        $this->attributes['event_type'] = $value > max(array_keys(self::$eventTypes)) ? null : $value; // 1-based
    }

    public function setAudienceAttribute($value)
    {
        $this->attributes['audience'] = $value > max(array_keys(self::$eventAudiences)) ? null : $value; // 1-based
    }

    public function setEntranceAttribute($value)
    {
        $this->attributes['entrance'] = $value > max(array_keys(self::$eventEntrances)) ? null : $value; // 1-based
    }

    public function setAffiliateGroupIdAttribute($value)
    {
        $this->attributes['affiliate_group_id'] = ($value == self::NULL_OPTION_AFFILIATE_GROUP) ? null : $value;
    }

    public function setEventHostIdAttribute($value)
    {
        $this->attributes['event_host_id'] = ($value == self::NULL_OPTION_EVENT_HOST) ? null : $value;
    }

    public function scopeDefault($query)
    {
        return $this->scopeSixMonths($query);
    }

    public function scopeSixMonths($query)
    {
        return $query->betweenDates(Carbon::today(), Carbon::today()->addMonths(6));
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

    public function getNextOccurrenceExclusiveAttribute()
    {
        return $this->eventMetas()->where('date', '>=', Carbon::now())->orderBy('date', 'ASC')->first();
    }

    public function getNextOccurrenceAttribute()
    {
        return $this->eventMetas()->where('date_end', '>=', Carbon::now())->orderBy('date', 'ASC')->first();
    }

    public function getLastOccurrenceAttribute()
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
                'name' => 'title',
                'doc' => 'Title',
                'type' => 'string',
                'value' => function () {
                    return $this->title;
                },
            ],
            [
                'name' => 'title_display',
                'doc' => 'Display Title',
                'type' => 'string',
                'value' => function () {
                    return $this->title_display;
                },
            ],
            [
                'name' => 'image_url',
                'doc' => 'Image URL',
                'type' => 'string',
                'value' => function () {
                    return $this->present()->imageUrl();
                },
            ],
            [
                'name' => 'hero_caption',
                'doc' => 'Hero caption',
                'type' => 'string',
                'value' => function () {
                    return $this->hero_caption;
                },
            ],
            [
                'name' => 'header_description',
                'doc' => 'Header Description',
                'type' => 'string',
                'value' => function () {
                    return $this->description;
                },
            ],
            [
                'name' => 'short_description',
                'doc' => 'Short Description',
                'type' => 'string',
                'value' => function () {
                    return $this->short_description;
                },
            ],
            [
                'name' => 'list_description',
                'doc' => 'list_description',
                'type' => 'string',
                'value' => function () {
                    return $this->list_description;
                },
            ],
            [
                'name' => 'description',
                'doc' => 'All copy text',
                'type' => 'string',
                'value' => function () {
                    return $this->present()->copy();
                },
            ],
            [
                'name' => 'location',
                'doc' => 'Location',
                'type' => 'string',
                'value' => function () {
                    return $this->location;
                },
            ],
            [
                'name' => 'event_type',
                'doc' => 'Type',
                'type' => 'number',
                'value' => function () {
                    return $this->event_type;
                },
            ],
            [
                'name' => 'alt_event_types',
                'doc' => 'Alternate Type',
                'type' => 'number',
                'value' => function () {
                    return Arr::pluck($this->alt_types, 'id');
                },
            ],
            [
                'name' => 'audience',
                'doc' => 'Audience',
                'type' => 'string',
                'value' => function () {
                    return $this->audience;
                },
            ],
            [
                'name' => 'alt_audiences',
                'doc' => 'Alternate Audiences',
                'type' => 'number',
                'value' => function () {
                    return Arr::pluck($this->alt_audiences, 'id');
                },
            ],
            [
                'name' => 'programs',
                'doc' => 'Programs',
                'type' => 'number',
                'value' => function () {
                    return Arr::pluck($this->programs, 'pivot.event_program_id');
                },
            ],
            [
                'name' => 'is_ticketed',
                'doc' => 'Is ticketed',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_ticketed;
                },
            ],
            [
                'name' => 'ticketed_event_id',
                'doc' => 'Unique identifer of the event in our central ticketing system',
                'type' => 'string',
                'value' => function () {
                    $ticketedEvent = $this->apiModels('ticketedEvent', 'TicketedEvent')->first();

                    return $ticketedEvent ? $ticketedEvent->id : null;
                },
            ],
            [
                'name' => 'buy_tickets_link',
                'doc' => 'buy_tickets_link',
                'type' => 'string',
                'value' => function () {
                    return $this->buy_tickets_link;
                },
            ],
            [
                'name' => 'rsvp_link',
                'doc' => 'RSVP Link',
                'type' => 'string',
                // WEB-1198: Derive sales site link from related ticketed event
                'value' => function () {
                    return $this->buy_tickets_link;
                },
            ],
            [
                'name' => 'buy_button_text',
                'doc' => 'buy_button_text',
                'type' => 'string',
                // WEB-1198: Derive sales site link from related ticketed event
                'value' => function () {
                    return $this->present()->buyButtonText();
                },
            ],
            [
                'name' => 'buy_button_caption',
                'doc' => 'buy_button_caption',
                'type' => 'string',
                'value' => function () {
                    return $this->buy_button_caption;
                },
            ],
            [
                'name' => 'is_registration_required',
                'doc' => 'Is Registration required',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_registration_required;
                },
            ],
            [
                'name' => 'is_member_exclusive',
                'doc' => 'Is member exclusive',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_member_exclusive;
                },
            ],
            [
                'name' => 'is_sold_out',
                'doc' => 'is_sold_out',
                'type' => 'boolean',
                // WEB-414: Do not use `$this->present()->isSoldOut` here
                'value' => function () {
                    return $this->is_sold_out;
                },
            ],
            [
                'name' => 'is_free',
                'doc' => 'Is Free',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_free;
                },
            ],
            [
                'name' => 'is_rsvp',
                'doc' => 'Is RSVP',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_rsvp;
                },
            ],
            [
                'name' => 'is_private',
                'doc' => 'Is Private',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_private;
                },
            ],
            [
                'name' => 'is_sales_button_hidden',
                'doc' => 'Is Sales Button Hidden',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_sales_button_hidden;
                },
            ],
            [
                'name' => 'start_time',
                'doc' => 'Start Time',
                'type' => 'string',
                'value' => function () {
                    // https://www.php.net/manual/en/dateinterval.format.php
                    return $this->start_time ? \Carbon\CarbonInterval::create($this->start_time)->format('%H:%I') : null;
                }
            ],
            [
                'name' => 'end_time',
                'doc' => 'End Time',
                'type' => 'string',
                'value' => function () {
                    // https://www.php.net/manual/en/dateinterval.format.php
                    return $this->end_time ? \Carbon\CarbonInterval::create($this->end_time)->format('%H:%I') : null;
                }
            ],
            [
                'name' => 'start_date',
                'doc' => 'Date the event begins',
                'type' => 'string',
                'value' => function () {
                    return $this->date_start ? $this->date_start->toIso8601String() : null;
                },
            ],
            [
                'name' => 'end_date',
                'doc' => 'Date the event ends',
                'type' => 'string',
                'value' => function () {
                    return $this->date_end ? $this->date_end->toIso8601String() : null;
                },
            ],
            [
                'name' => 'forced_date',
                'doc' => 'forced_date',
                'type' => 'string',
                'value' => function () {
                    return $this->forced_date;
                },
            ],
            [
                'name' => 'door_time',
                'doc' => 'door_time',
                'type' => 'string',
                'value' => function () {
                    // https://www.php.net/manual/en/dateinterval.format.php
                    return $this->door_time ? \Carbon\CarbonInterval::create($this->door_time)->format('%H:%I') : null;
                }
            ],
            [
                'name' => 'sponsor_id',
                'doc' => 'Sponsor ID',
                'type' => 'integer',
                'value' => function () {
                    return $this->sponsors->first()->id ?? null;
                },
            ],
            [
                'name' => 'content',
                'doc' => 'Content',
                'type' => 'string',
                'value' => function () {
                    return $this->content;
                },
            ],
            [
                'name' => 'layout_type',
                'doc' => 'Layout Type',
                'type' => 'number',
                'value' => function () {
                    return $this->layout_type;
                },
            ],
            [
                'name' => 'published',
                'doc' => 'Published',
                'type' => 'boolean',
                'value' => function () {
                    return $this->published;
                },
            ],
            [
                'name' => 'publish_start_date',
                'doc' => 'Publish Start Date',
                'type' => 'datetime',
                'value' => function () {
                    return $this->publish_start_date;
                }
            ],
            [
                'name' => 'publish_end_date',
                'doc' => 'Publish End Date',
                'type' => 'datetime',
                'value' => function () {
                    return $this->publish_end_date;
                }
            ],
            [
                'name' => 'slug',
                'doc' => 'slug',
                'type' => 'string',
                'value' => function () {
                    return $this->slug;
                },
            ],
            [
                'name' => 'web_url',
                'doc' => 'web_url',
                'type' => 'string',
                'value' => function () {
                    return url(route('events.show', $this));
                },
            ],
            [
                'name' => 'search_tags',
                'doc' => 'search_tags',
                'type' => 'string',
                'value' => function () {
                    return $this->search_tags;
                },
            ],
            [
                'name' => 'is_admission_required',
                'doc' => 'Is admission required',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_admission_required;
                },
            ],
            [
                'name' => 'is_after_hours',
                'doc' => 'Is after hours',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_after_hours;
                },
            ],
            [
                'name' => 'entrance',
                'doc' => 'Which entrance to use for this event',
                'type' => 'string',
                'value' => function () {
                    return self::$eventEntrances[$this->entrance] ?? null;
                },
            ],
            [
                'name' => 'is_virtual_event',
                'doc' => 'Is virtual event',
                'type' => 'boolean',
                'value' => function () {
                    return $this->is_virtual_event;
                },
            ],
            [
                'name' => 'virtual_event_url',
                'doc' => 'Virtual event URL',
                'type' => 'string',
                'value' => function () {
                    return $this->virtual_event_url;
                },
            ],
            [
                'name' => 'virtual_event_passcode',
                'doc' => 'Virtual event passcode',
                'type' => 'string',
                'value' => function () {
                    return $this->virtual_event_passcode;
                },
            ],
            [
                'name' => 'affiliate_group_id',
                'doc' => 'Identifier of affiliate group (event program) associated with this event',
                'type' => 'boolean',
                'value' => function () {
                    return $this->affiliateGroup->id ?? null;
                },
            ],
            [
                'name' => 'event_host_id',
                'doc' => 'Identifier of an event host (event program) associated with this event',
                'type' => 'boolean',
                'value' => function () {
                    return $this->eventHost->id ?? null;
                },
            ],
            [
                'name' => 'join_url',
                'doc' => 'URL to the membership signup page',
                'type' => 'string',
                'value' => function () {
                    return $this->join_url;
                },
            ],
            [
                'name' => 'survey_url',
                'doc' => 'URL to the survey associated with this event',
                'type' => 'string',
                'value' => function () {
                    return $this->survey_url;
                },
            ],
            [
                'name' => 'test_emails',
                'doc' => 'Extra email addresses to which to send email series tests',
                'type' => 'string',
                'value' => function () {
                    return $this->test_emails;
                },
            ],
            [
                'name' => 'email_series',
                'doc' => 'email_series',
                'type' => 'string',
                'value' => function () {
                    $eventHostTitle = $this->eventHost->name ?? null;
                    $emailSeriesPivots = $this->emailSeries->pluck('pivot');

                    return $emailSeriesPivots->each(function ($item) use ($eventHostTitle) {
                        foreach (
                            [
                            'affiliate_copy',
                            'member_copy',
                            'luminary_copy',
                            'nonmember_copy',
                            ] as $field
                        ) {
                            if (isset($item->{$field})) {
                                if (isset($eventHostTitle)) {
                                    $item->{$field} = str_replace(
                                        '%%EventHost%%',
                                        $eventHostTitle,
                                        $item->{$field}
                                    );
                                } else {
                                    $paragraphs = preg_split('/(?<=<\/p>)\s*(?=<p)/', $item->{$field}, -1, PREG_SPLIT_DELIM_CAPTURE);
                                    $paragraphs = array_filter($paragraphs, function ($paragraph) {
                                        return strpos($paragraph, '%%EventHost%%') === false;
                                    });
                                    $item->{$field} = count($paragraphs) > 0 ? implode('', $paragraphs) : null;
                                }
                            }
                        }
                    });
                },
            ],
        ];
    }
}

<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasAutoRelated;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasFeaturedRelated;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Exhibition extends AbstractModel
{
    use HasRevisions;
    use HasSlug;
    use HasMedias;
    use HasMediasEloquent;
    use HasBlocks;
    use HasApiModel;
    use Transformable;
    use HasRelated;
    use HasApiRelations;
    use HasFeaturedRelated;
    use HasAutoRelated;

    protected $apiModel = 'App\Models\Api\Exhibition';

    protected $presenter = 'App\Presenters\Admin\ExhibitionPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\ExhibitionPresenter';

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdateExhibition::class,
        'deleted' => \App\Events\UpdateExhibition::class,
    ];

    public const BASIC = 0;
    public const LARGE = 1;
    public const SPECIAL = 2;

    public const OPEN = 'Open';
    public const CLOSED = 'Closed';
    public const ONGOING = 'Ongoing';

    protected $fillable = [
        'published',
        'content',
        'header_copy',
        'title',
        'title_display',
        'datahub_id',
        'exhibition_message',
        'exhibition_location',
        'status_override',
        'list_description',
        'cms_exhibition_type',
        'hero_caption',
        'meta_title',
        'meta_description',
        'public_start_date',
        'public_end_date',
        'member_preview_start_date',
        'member_preview_end_date',
        'date_display_override',
        'product_section_title',
        'product_section_title_link_label',
        'product_section_title_link_href',
        'wait_time_override',
        'toggle_autorelated',
    ];

    protected $casts = [
        'public_start_date' => 'date',
        'public_end_date' => 'date',
        'member_preview_start_date' => 'date',
        'member_preview_end_date' => 'date',
        'published' => 'boolean',
        'toggle_autorelated' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
        'toggle_autorelated' => false,
    ];

    public $slugAttributes = [
        'title',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'special' => [
                [
                    'name' => 'special',
                    'ratio' => 1 / 1,
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

    public static $exhibitionTypes = [
        self::BASIC => 'Basic',
        self::LARGE => 'Large feature',
        self::SPECIAL => 'Special exhibition',
    ];

    public static $exhibitionStatuses = [
        self::OPEN => self::OPEN,
        self::CLOSED => self::CLOSED,
        self::ONGOING => self::ONGOING,
    ];

    public function exhibitions()
    {
        return $this->apiElements()->where('relation', 'exhibitions');
    }

    public function shopItems()
    {
        return $this->apiElements()->where('relation', 'shopItems');
    }

    public function siteTags()
    {
        return $this->morphToMany(\App\Models\SiteTag::class, 'site_taggable', 'site_tagged');
    }

    public function sponsors()
    {
        return $this->belongsToMany(\App\Models\Sponsor::class)->withPivot('position')->orderBy('position');
    }

    public function waitTimes()
    {
        return $this->apiElements()->where('relation', 'waitTimes');
    }

    public function getTitleInBucketAttribute()
    {
        return $this->title;
    }

    public function getAdminEditUrlAttribute()
    {
        return route('admin.exhibitions_events.exhibitions.edit', $this->id);
    }

    public function events()
    {
        return $this->belongsToMany('App\Models\Event')->withPivot('position')->orderBy('position');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer')->orderBy('position');
    }

    public function eventsCount()
    {
        $query = $this->events()->rightJoin('event_metas', function ($join) {
            $join->on('events.id', '=', 'event_metas.event_id');
        });
        $query->where('event_metas.date', '>=', Carbon::today());

        return $query->count();
    }

    public function getUrlWithoutSlugAttribute()
    {
        return route('exhibitions.show', ['id' => $this->datahub_id]);
    }

    protected function transformMappingInternal()
    {
        return [
            [
                'name' => 'is_featured',
                'doc' => 'Is this exhibition in the primary or secondary feature listings on the landing page?',
                'type' => 'boolean',
                'value' => function () {
                    return $this->present()->isFeatured();
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
                'name' => 'title',
                'doc' => 'The title of  this exhibition',
                'type' => 'string',
                'value' => function () {
                    return $this->title;
                },
            ],
            [
                'name' => 'header_copy',
                'doc' => 'Header Copy',
                'type' => 'string',
                'value' => function () {
                    return $this->header_copy;
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
                'name' => 'content',
                'doc' => 'Content',
                'type' => 'string',
                'value' => function () {
                    return $this->content;
                },
            ],
            [
                'name' => 'image_url',
                'doc' => 'Image URL',
                'type' => 'string',
                'value' => function () {
                    return Str::startsWith($this->image('hero'), 'http') ? $this->image('hero') : null;
                },
            ],
            [
                'name' => 'web_url',
                'doc' => 'Web URL',
                'type' => 'string',
                'value' => function () {
                    return route('exhibitions.show', ['id' => $this->datahub_id, 'slug' => $this->getSlug()]);
                },
            ],
            [
                'name' => 'datahub_id',
                'doc' => 'Souce ID',
                'type' => 'string',
                'value' => function () {
                    return (int) $this->datahub_id;
                },
            ],
            [
                'name' => 'exhibition_message',
                'doc' => 'Message',
                'type' => 'string',
                'value' => function () {
                    return $this->exhibition_message;
                },
            ],
            [
                'name' => 'public_start_at',
                'doc' => 'Public opening at',
                'type' => 'string',
                'value' => function () {
                    return $this->public_start_date ? $this->public_start_date->toIso8601String() : null;
                },
            ],
            [
                'name' => 'public_end_at',
                'doc' => 'Public closing at',
                'type' => 'string',
                'value' => function () {
                    return $this->public_end_date ? $this->public_end_date->toIso8601String() : null;
                },
            ],
            [
                'name' => 'date_display',
                'doc' => 'Formatted date with override',
                'type' => 'string',
                'value' => function () {
                    // WEB-1822, WEB-1830: This causes errors when the API model isn't found, needs more work on several fronts
                    // return trim(html_entity_decode(strip_tags($this->getApiModelFilledCached()->present()->formattedDate()->render())));
                },
            ],
            [
                'name' => 'position',
                'doc' => 'Position this exhibition has on the exhibition landing page',
                'type' => 'integer',
                'value' => function () {
                    return $this->present()->position();
                },
            ],
            [
                'name' => 'related',
                'doc' => 'Related Content',
                'type' => 'array',
                'value' => function () {
                    return $this->transformRelated();
                },
            ],
        ];
    }

    public function getIsFeaturedAttribute()
    {
        // @see ExhibitionsController::index and relations on Page model
        $page = Page::forType('Exhibitions and Events')->with('apiElements')->first();

        $featuredIds = $page->present()->upcomingListedExhibitions()->take(2)
            ->merge($page->present()->currentListedExhibitions()->take(2))
            ->pluck('id')
            ->all();

        return in_array($this->datahub_id, $featuredIds);
    }
}

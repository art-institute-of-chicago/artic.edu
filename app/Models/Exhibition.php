<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRelated;
use App\Models\Behaviors\HasFeaturedRelated;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Exhibition extends AbstractModel
{
    use HasRevisions, HasSlug, HasMedias, HasMediasEloquent, HasBlocks, HasApiModel, HasApiRelations, Transformable, HasRelated, HasFeaturedRelated;

    protected $apiModel = 'App\Models\Api\Exhibition';

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdateExhibition::class,
        'deleted' => \App\Events\UpdateExhibition::class,
    ];

    const BASIC = 0;
    const LARGE = 1;
    const SPECIAL = 2;

    const OPEN = 'Open';
    const CLOSED = 'Closed';
    const ONGOING = 'Ongoing';

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
        'product_section_title',
        'product_section_title_link_label',
        'product_section_title_link_href',
    ];

    protected $casts = [
        'public_start_date' => 'date',
        'public_end_date' => 'date',
        'member_preview_start_date' => 'date',
        'member_preview_end_date' => 'date',
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
            'special' => [
                [
                    'name' => 'special',
                    'ratio' => 1 / 1,
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
        return route('exhibitions.show', $this->datahub_id);
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'is_featured',
                'doc' => 'Is this exhibition in the primary or secondary feature listings on the landing page?',
                'type' => 'boolean',
                'value' => function () {return $this->is_featured;},
            ],
            [
                "name" => 'published',
                "doc" => "Published",
                "type" => "boolean",
                "value" => function () {return $this->published;},
            ],
            [
                "name" => 'title',
                'doc' => 'The title of  this exhibition',
                'type' => 'string',
                'value' => function () {return $this->title;},
            ],
            [
                "name" => 'header_copy',
                "doc" => "Header Copy",
                "type" => "string",
                "value" => function () {return $this->header_copy;},
            ],
            [
                "name" => "list_description",
                "doc" => "list_description",
                "type" => "string",
                "value" => function () {return $this->list_description;},
            ],
            [
                "name" => 'content',
                "doc" => "Content",
                "type" => "string",
                "value" => function () {return $this->content;},
            ],
            [
                "name" => 'image_url',
                "doc" => "Image URL",
                "type" => "string",
                "value" => function () {return Str::startsWith($this->image('hero'), 'http') ? $this->image('hero') : null;},
            ],
            [
                "name" => 'web_url',
                "doc" => "Web URL",
                "type" => "string",
                "value" => function () {return route('exhibitions.show', ['id' => $this->datahub_id, 'slug' => $this->getSlug() ]); },
            ],
            [
                "name" => 'datahub_id',
                "doc" => "Souce ID",
                "type" => "string",
                "value" => function () {return (int) $this->datahub_id;},
            ],
            [
                "name" => 'exhibition_message',
                "doc" => "Message",
                "type" => "string",
                "value" => function () {return $this->exhibition_message;},
            ],
            [
                "name" => 'exhibition_location',
                "doc" => "Location",
                "type" => "string",
                "value" => function () {return $this->exhibition_location;},
            ],
            [
                "name" => 'cms_exhibition_type',
                "doc" => "CMS Type",
                "type" => "number",
                "value" => function () {return $this->cms_exhibition_type;},
            ],
            [
                "name" => 'related',
                "doc" => "Related Content",
                "type" => "array",
                "value" => function () { return $this->transformRelated(); },
            ],
        ];
    }

    public function getIsFeaturedAttribute() {

        // See ExhibitionsController::index and relations on Page model
        $page = Page::forType('Exhibitions and Events')->with('apiElements')->first();

        $featuredIds = $page->apiElements()->whereIn('relation', [
            'exhibitionsExhibitions',
            'exhibitionsCurrent',
            'exhibitionsUpcoming',
            'exhibitionsUpcomingListing',
        ])->get(['datahub_id'])->pluck('datahub_id')->all();

        return in_array($this->datahub_id, $featuredIds);

    }

}

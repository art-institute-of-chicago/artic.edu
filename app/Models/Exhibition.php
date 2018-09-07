<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Model;
use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Page;
use Carbon\Carbon;

class Exhibition extends Model
{
    use HasRevisions, HasSlug, HasMedias, HasMediasEloquent, HasBlocks, HasApiModel, HasApiRelations, Transformable;

    protected $apiModel = 'App\Models\Api\Exhibition';

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdateExhibition::class,
        'deleted' => \App\Events\UpdateExhibition::class,
    ];

    protected $selectedFeaturedRelated = null;

    const BASIC = 0;
    const LARGE = 1;
    const SPECIAL = 2;

    protected $fillable = [
        'published',
        'content',
        'header_copy',
        'title',
        'title_display',
        'datahub_id',
        'exhibition_message',
        'list_description',
        'cms_exhibition_type',
        'hero_caption',
        'meta_title',
        'meta_description',
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
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];

    public static $exhibitionTypes = [
        self::BASIC => 'Basic',
        self::LARGE => 'Large feature',
        self::SPECIAL => 'Special exhibition',
    ];

    public function exhibitions()
    {
        return $this->apiElements()->where('relation', 'exhibitions');
    }

    public function sidebarExhibitions()
    {
        return $this->apiElements()->where('relation', 'sidebarExhibitions');
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

    public function events()
    {
        return $this->belongsToMany('App\Models\Event')->withPivot('position')->orderBy('position');
    }

    public function sidebarEvent()
    {
        return $this->belongsToMany('App\Models\Event', 'exhibition_event_sidebar')->withPivot('position')->orderBy('position');
    }

    public function articles()
    {
        return $this->belongsToMany('App\Models\Article')->withPivot('position')->orderBy('position');
    }

    public function videos()
    {
        return $this->belongsToMany('App\Models\Video')->withPivot('position')->orderBy('position');
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

    public function getFeaturedRelatedAttribute()
    {
        // Select a random element from these relationships below and return one per request
        if ($this->selectedFeaturedRelated) {
            return $this->selectedFeaturedRelated;
        }

        $types = collect(['articles', 'videos', 'sidebarExhibitions', 'sidebarEvent'])->shuffle();
        foreach ($types as $type) {
            if ($item = $this->$type()->first()) {
                switch ($type) {
                    case 'videos':
                        $type = 'medias';
                        break;
                    case 'sidebarEvent':
                        $type = 'event';
                        break;
                    case 'sidebarExhibitions':
                        $item = $this->apiModels('sidebarExhibitions', 'Exhibition')->first();
                        $type = 'exhibition';
                        break;
                }

                $this->selectedFeaturedRelated = [
                    'type' => str_singular($type),
                    'items' => [$item],
                ];
                return $this->selectedFeaturedRelated;
            }
        }
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
                "name" => 'datahub_id',
                "doc" => "Type",
                "type" => "string",
                "value" => function () {return $this->datahub_id;},
            ],
            [
                "name" => 'exhibition_message',
                "doc" => "Message",
                "type" => "string",
                "value" => function () {return $this->exhibition_message;},
            ],
            [
                "name" => 'cms_exhibition_type',
                "doc" => "CMS Type",
                "type" => "number",
                "value" => function () {return $this->cms_exhibition_type;},
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

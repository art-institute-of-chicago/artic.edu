<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;
use Carbon\Carbon;

use App\Models\Behaviors\HasApiModel;
use App\Models\Behaviors\HasApiRelations;
use App\Models\Behaviors\HasMediasEloquent;

class Exhibition extends Model
{
    use HasRevisions, HasSlug, HasMedias, HasMediasEloquent, HasBlocks, HasApiModel, HasApiRelations, Transformable;

    protected $apiModel = 'App\Models\Api\Exhibition';

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdateExhibition::class,
        'deleted' => \App\Events\UpdateExhibition::class
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
        'datahub_id',
        'is_visible',
        'exhibition_message',
        'list_description',
        'sponsors_description',
        'sponsors_sub_copy',
        'cms_exhibition_type',
        'hero_caption'
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published', 'is_visible'];

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
        self::BASIC   => 'Basic',
        self::LARGE   => 'Large feature',
        self::SPECIAL => 'Special exhibition'
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
        return join([route('exhibitions'), '/', $this->datahub_id, '-']);
    }

    public function getFeaturedRelatedAttribute()
    {
        // Select a random element from these relationships below and return one per request
        if ($this->selectedFeaturedRelated)
            return $this->selectedFeaturedRelated;

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
                    'items' => [$item]
                ];
                return $this->selectedFeaturedRelated;
            }
        }
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => 'published',
                "doc" => "Published",
                "type" => "boolean",
                "value" => function() { return $this->published; }
            ],
            [
                "name" => 'header_copy',
                "doc" => "Header Copy",
                "type" => "string",
                "value" => function() { return $this->header_copy; }
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
                "value" => function() { return $this->content; }
            ],
            [
                "name" => 'datahub_id',
                "doc" => "Type",
                "type" => "string",
                "value" => function() { return $this->datahub_id; }
            ],
            [
                "name" => 'is_visible',
                "doc" => "Visible",
                "type" => "boolean",
                "value" => function() { return $this->is_visible; }
            ],
            [
                "name" => 'exhibition_message',
                "doc" => "Message",
                "type" => "string",
                "value" => function() { return $this->exhibition_message; }
            ],
            [
                "name" => 'sponsors_description',
                "doc" => "Description",
                "type" => "string",
                "value" => function() { return $this->sponsors_description; }
            ],
            [
                "name" => 'cms_exhibition_type',
                "doc" => "CMS Type",
                "type" => "number",
                "value" => function() { return $this->cms_exhibition_type; }
            ],
            [
                "name" => 'sponsors_sub_copy',
                "doc" => "Sub Copy",
                "type" => "string",
                "value" => function() { return $this->sponsors_sub_copy; }
            ],
            [
                "name" => 'sponsors_description',
                "doc" => "sponsors_description",
                "type" => "string",
                "value" => function() { return $this->sponsors_description; }
            ],
        ];
    }

}

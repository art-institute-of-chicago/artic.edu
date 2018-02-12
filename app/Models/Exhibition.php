<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;

use App\Models\Behaviors\HasApiModel;

class Exhibition extends Model
{
    use HasRevisions, HasSlug, HasMedias, HasBlocks, HasApiModel, Transformable;

    protected $presenter      = 'App\Presenters\Admin\ExhibitionPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\ExhibitionPresenter';
    protected $apiModel = 'App\Models\Api\Exhibition';

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
        'sponsors_description',
        'sponsors_sub_copy',
        'cms_exhibition_type'
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
                    'ratio' => 9 / 16,
                ],
            ],
        ],
    ];

    public static $exhibitionTypes = [
        self::BASIC   => 'Basic',
        self::LARGE   => 'Large Feature',
        self::SPECIAL => 'Special Exhibition'
    ];

    public function apiElements()
    {
        return $this->morphToMany(\App\Models\ApiRelation::class, 'api_relatable')->withPivot(['position', 'relation'])->orderBy('position');
    }

    public function apiModels($relation, $model)
    {
        // TODO: Generalize, optimize and refactor
        $modelClass = "\\App\\Models\\Api\\" . ucfirst($model);
        $ids = $this->$relation->pluck('datahub_id')->toArray();
        return $modelClass::query()->ids($ids)->get();
    }

    public function exhibitions()
    {
        return $this->apiElements()->where('relation', 'exhibitions');
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
        ];
    }

}

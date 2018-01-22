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
    use HasRevisions, HasSlug, HasMedias, HasBlocks, HasApiModel;

    protected $presenterAdmin = 'App\Presenters\Admin\ExhibitionPresenter';
    protected $apiModel = 'App\Models\Api\Exhibition';

    protected $fillable = [
        'published',
        'content',
        'header_copy',
        'title',
        'datahub_id',
        'is_visible',
        'exhibition_message',
        'sponsors_description',
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
        0 => 'Basic',
        1 => 'Large Feature',
        2 => 'Special Exhibition'
    ];

    public function exhibitions()
    {
        return $this->morphToMany(\App\Models\ApiRelation::class, 'api_relatable')->withPivot(['position', 'relation'])->orderBy('position')->where('relation', 'exhibitions');
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
}

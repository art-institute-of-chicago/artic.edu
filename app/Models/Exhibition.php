<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasApiSource;
use A17\CmsToolkit\Models\Model;

class Exhibition extends Model
{
    use HasRevisions, HasSlug, HasMedias, HasBlocks, HasApiSource;

    protected $presenterAdmin = 'App\Presenters\Admin\ExhibitionPresenter';

    protected $endpoint = '/api/v1/exhibitions/{datahub_id}';

    protected $fillable = [
        'published',
        'landing',
        'content',
        'title',
        'header_copy',
        'start_date',
        'end_date',
        'short_copy',
        'datahub_id',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $nullable = [];

    public $checkboxes = ['published'];

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

    public function scopeLanding($query)
    {
        return $query->whereLanding(true);
    }

    public function events()
    {
        return $this->belongsToMany(\App\Models\Event::class, 'event_exhibition', 'event_id', 'exhibition_id')->withPivot('position')->orderBy('position');
    }

    public function shopItems()
    {
        return $this->morphToMany(\App\Models\ShopItem::class, 'shop_itemizable', 'shop_itemized');
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

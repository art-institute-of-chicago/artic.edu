<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasFiles;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Model;

use App\Models\Behaviors\HasMediasEloquent;

class PrintedCatalog extends Model
{
    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasMediasEloquent;

    protected $fillable = [
        'listing_description',
        'short_description',
        'title',
        'published',
        'public',
        'publish_start_date',
        'publish_end_date',
        'migrated_node_id',
        'migrated_at',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published', 'active', 'public'];
    public $dates = ['publish_start_date', 'publish_end_date', 'migrated_at'];

    protected $presenter = 'App\Presenters\Admin\GenericListingPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\GenericListingPresenter';

    public $mediasParams = [
        'listing' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 16 / 9,
                ],
            ],
            'mobile' => [
                [
                    'name' => 'mobile',
                    'ratio' => 1,
                ],
            ],
        ],
        'banner' => [
            'default' => [
                [
                    'name' => 'landscape',
                    'ratio' => 200 / 24,
                ],
            ]
        ],
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Models\CatalogCategory');
    }

    public function scopeByCategory($query, $category = null)
    {
        if (empty($category)) {
            return $query;
        }

        return $query->whereHas('categories', function ($query) use ($category){
            $query->where('catalog_category_id', $category);
        });
    }

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
        return join([route('collection.publications.printed-catalogs'), '/', $this->id, '-']);
    }

    public function getSlugAttribute()
    {
        return route('collection.publications.printed-catalogs.show', $this);
    }

}

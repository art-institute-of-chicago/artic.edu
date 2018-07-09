<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Model;
use App\Models\Behaviors\HasMediasEloquent;

class EducatorResource extends Model
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
        'meta_title',
        'meta_description',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published', 'active', 'public'];
    public $dates = ['publish_start_date', 'publish_end_date'];

    protected $presenter = 'App\Presenters\Admin\GenericPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\GenericPresenter';

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
            ],
        ],
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Models\ResourceCategory');
    }

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join([$this->id, $this->getSlug()], '-');
    }

    public function getUrlWithoutSlugAttribute()
    {
        return join([route('collection.publications.digital-catalogs'), '/', $this->id, '-']);
    }

    public function getSlugAttribute()
    {
        return route('collection.publications.digital-catalogs.show', $this);
    }

}

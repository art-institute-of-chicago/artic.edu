<?php

namespace App\Models;

use A17\CmsToolkit\Models\Model;
use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasFiles;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use App\Models\Behaviors\HasMediasEloquent;

class ExhibitionPressRoom extends Model
{

    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasMediasEloquent;

    protected $fillable = [
        'listing_description',
        'short_description',
        'title',
        'published',
        'publish_start_date',
        'publish_end_date',
        'public'
    ];

    public $checkboxes = ['published', 'public'];
    public $dates = ['publish_start_date', 'publish_end_date'];

    public $slugAttributes = [
        'title',
    ];

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
        return join([route('about.exhibitionPressRooms'), '/', $this->id, '-']);
    }

    public function getSlugAttribute()
    {
        return route('about.exhibitionPressRooms.show', $this);
    }

}

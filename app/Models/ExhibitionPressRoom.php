<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasMediasEloquent;

class ExhibitionPressRoom extends AbstractModel
{

    use HasBlocks, HasSlug, HasMedias, HasFiles, HasRevisions, HasMediasEloquent;

    protected $fillable = [
        'listing_description',
        'short_description',
        'title',
        'title_display',
        'published',
        'publish_start_date',
        'publish_end_date',
        'public',
    ];

    public $checkboxes = ['published', 'public'];
    public $dates = ['publish_start_date', 'publish_end_date'];

    public $slugAttributes = [
        'title',
    ];

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

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join([$this->id, $this->getSlug()], '/');
    }

    public function getUrlAttribute()
    {
        return url(route('about.exhibitionPressRooms.show', $this->id_slug));
    }

    public function getUrlWithoutSlugAttribute()
    {
        return join([route('about.exhibitionPressRooms'), '/', $this->id, '-']);
    }

    public function getSlugAttribute()
    {
        return route('about.exhibitionPressRooms.show', $this);
    }

    public function getAdminEditUrlAttribute()
    {
        return route('admin.generic.exhibitionPressRooms.edit', $this->id);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('publish_start_date', 'desc');
    }
}

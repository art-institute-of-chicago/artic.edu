<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMedias;
use App\Models\Behaviors\HasMediasEloquent;

class ExhibitionPressRoom extends AbstractModel
{
    use HasBlocks;
    use HasSlug;
    use HasMedias;
    use HasFiles;
    use HasRevisions;
    use HasMediasEloquent;

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

    public $casts = [
        'publish_start_date' => 'date',
        'publish_end_date' => 'date',
        'published' => 'boolean',
        'public' => 'boolean',
    ];

    public $attributes = [
        'published' => false,
        'public' => false,
    ];

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

    /**
     * Generates the id-slug type of URL
     */
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join('/', [$this->id, $this->getSlug()]);
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

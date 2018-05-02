<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;
use A17\CmsToolkit\Models\Behaviors\HasPresenter;

class Artist extends BaseApiModel
{
    use HasPresenter;

    protected $endpoints = [
        'collection' => '/api/v1/agents',
        'resource'   => '/api/v1/agents/{id}',
        'search'     => '/api/v1/agents/search'
    ];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\Artist';

    protected $presenter       = 'App\Presenters\Admin\ArtistPresenter';
    protected $presenterAdmin  = 'App\Presenters\Admin\ArtistPresenter';

    public function getTypeAttribute()
    {
        return 'artist';
    }

    public function artworks()
    {
        return $this->hasMany(\App\Models\Api\Artwork::class, 'artwork_ids');
    }
}

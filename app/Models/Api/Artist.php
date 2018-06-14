<?php

namespace App\Models\Api;

use A17\Twill\Models\Behaviors\HasPresenter;
use App\Libraries\Api\Models\BaseApiModel;

class Artist extends BaseApiModel
{
    use HasPresenter;

    protected $endpoints = [
        'collection' => '/api/v1/agents',
        'resource' => '/api/v1/agents/{id}',
        'search' => '/api/v1/agents/search',
    ];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\Artist';

    protected $presenter = 'App\Presenters\Admin\ArtistPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\ArtistPresenter';

    public function getTypeAttribute()
    {
        return 'artist';
    }

    public function artworks()
    {
        return $this->hasMany(\App\Models\Api\Artwork::class, 'artwork_ids');
    }

    public function getAlsoKnownAsAttribute()
    {
        if (!empty($this->alt_titles)) {
            return join(', ', $this->alt_titles);
        }
    }
}

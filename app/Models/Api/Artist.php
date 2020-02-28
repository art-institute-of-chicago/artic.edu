<?php

namespace App\Models\Api;

use App\Libraries\Api\Models\BaseApiModel;

class Artist extends BaseApiModel
{
    protected $endpoints = [
        'collection' => '/api/v1/artists',
        'resource'   => '/api/v1/artists/{id}',
        'search'     => '/api/v1/artists/search'
    ];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\Artist';

    protected $presenter = 'App\Presenters\Admin\ArtistPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\ArtistPresenter';

    protected static $defaultScopes = [
        'include' => ['place_pivots']
    ];
    protected $artworks;

    public function getTypeAttribute()
    {
        return 'artist';
    }

    public function artworks($perPage = 20)
    {
        return $this->artworks ?? $this->artworks = Search::query()
            ->resources(['artworks'])
            ->forceEndpoint('search')
            ->byArtists($this->title)
            ->aggregationClassifications(2)
            ->aggregationPlaces(1)
            ->aggregationStyles(1)
            ->getSearch($perPage);
    }

    public function getTitleSlugAttribute()
    {
        return getUtf8Slug($this->title);
    }

    public function getAlsoKnownAsAttribute()
    {
        if (!empty($this->alt_titles)) {
            return join(', ', $this->alt_titles);
        }
    }
}

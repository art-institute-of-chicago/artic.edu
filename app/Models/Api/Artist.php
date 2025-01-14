<?php

namespace App\Models\Api;

use Aic\Hub\Foundation\Library\Api\Models\BaseApiModel;
use App\Helpers\StringHelpers;

class Artist extends BaseApiModel
{
    protected array $endpoints = [
        'collection' => '/api/v1/artists',
        'resource' => '/api/v1/artists/{id}',
        'search' => '/api/v1/artists/search'
    ];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\Artist';

    protected $presenter = 'App\Presenters\Admin\ArtistPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\ArtistPresenter';

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
            ->getSearch(
                $perPage,
                \App\Models\Api\Artwork::SEARCH_FIELDS,
                'page',
                null,
                [
                    'do-not-extract' => true
                ]
            );
    }

    public function getTitleSlugAttribute()
    {
        return StringHelpers::getUtf8Slug($this->title);
    }

    public function getAlsoKnownAsAttribute()
    {
        if (!empty($this->alt_titles)) {
            return join(', ', $this->alt_titles);
        }
    }

    public function getShortNameDisplayAttribute()
    {
        $augmentedArtist = $this->getAugmentedModel();

        if ($augmentedArtist && $augmentedArtist->short_name_display) {
            return $augmentedArtist->short_name_display;
        }

        return $this->short_name;
    }

    public function getShortNameCaptionAttribute()
    {
        $augmentedArtist = $this->getAugmentedModel();

        if ($augmentedArtist && $augmentedArtist->short_name_caption) {
            return $augmentedArtist->short_name_caption;
        }

        return $this->short_name_qualifier;
    }

    public function getShortNameAttribute()
    {
        $arr = explode(',', $this->sort_title, 2);

        return $arr[0];
    }

    public function getShortNameQualifierAttribute()
    {
        $arr = explode(',', $this->sort_title, 2);

        return count($arr) > 1 ? trim($arr[1]) : '';
    }
}

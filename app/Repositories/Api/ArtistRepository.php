<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Artist;
use App\Models\Api\Search;
use App\Repositories\Api\BaseApiRepository;
use App\Repositories\Behaviors\ExploreFurtherTags;

class ArtistRepository extends BaseApiRepository
{
    // Trait used to build explore further on all tag pages.
    use ExploreFurtherTags;

    const PER_PAGE_EXPLORE_FURTHER = 20;
    const EXPLORE_FURTHER_TAGS = 55;
    const ARTWORKS_PER_PAGE = 8;

    public function __construct(Artist $model)
    {
        $this->model = $model;
    }

    public function getArtworksCollection($item)
    {
        return Search::query()
                ->resources(['artworks'])
                ->forceEndpoint('search')
                ->byArtists($item->title)
                ->aggregationClassifications()
                ->getSearch(self::ARTWORKS_PER_PAGE);
    }

}

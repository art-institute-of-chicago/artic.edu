<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Gallery;
use App\Models\Api\Search;
use App\Repositories\Api\BaseApiRepository;
use App\Repositories\Behaviors\ExploreFurtherTags;

class GalleryRepository extends BaseApiRepository
{
    // Trait used to build explore further on all tag pages.
    use ExploreFurtherTags;

    const PER_PAGE_EXPLORE_FURTHER = 20;
    const EXPLORE_FURTHER_TAGS = 55;
    const ARTWORKS_PER_PAGE = 8;

    public function __construct(Gallery $model)
    {
        $this->model = $model;
    }

    public function getArtworksCollection($item)
    {
        return Search::query()
                ->resources(['artworks'])
                ->forceEndpoint('search')
                ->byGalleryIds($item->id)
                ->aggregationClassifications()
                ->getSearch(self::ARTWORKS_PER_PAGE);
    }

}

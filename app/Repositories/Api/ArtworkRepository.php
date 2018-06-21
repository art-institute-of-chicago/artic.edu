<?php

namespace App\Repositories\Api;

use App\Models\Api\Artwork;
use App\Repositories\Api\BaseApiRepository;

class ArtworkRepository extends BaseApiRepository
{

    public function __construct(Artwork $model)
    {
        $this->model = $model;
    }

    // public function exploreFurtherAllTags()
    // {
    //     // Build All Tags tab
    //     $exploreFurtherTags = Search::query()
    //         ->forceEndpoint('search')
    //         ->resources(['artworks'])
    //         ->aggregationClassifications(self::EXPLORE_FURTHER_TAGS)
    //         ->forPage(1, 0)
    //         ->get();

    //     $buckets = $exploreFurtherTags->getMetadata('aggregations')->classifications->buckets;

    //     return collect($buckets)->mapWithKeys(function ($item) {
    //         return [$item->key => ucfirst($item->key)];
    //     });
    // }

}

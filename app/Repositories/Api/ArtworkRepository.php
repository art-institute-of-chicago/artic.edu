<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Artwork;
use App\Models\Api\Search;
use App\Repositories\Api\BaseApiRepository;

class ArtworkRepository extends BaseApiRepository
{
    const PER_PAGE_EXPLORE_FURTHER = 8;

    public function __construct(Artwork $model)
    {
        $this->model = $model;
    }

    public function exploreFurtherCollection($item, $filteredId = null)
    {
        if ($item->classificationIds) {
            $query = $this->model->query();

            if ($filteredId){
                $query->byClassifications([$filteredId]);
            } else {
                $query->byClassifications($item->classificationIds);
            }

            return $query->getSearch(self::PER_PAGE_EXPLORE_FURTHER);
        }
    }

    public function exploreFurtherTags($item)
    {
        if ($item->classificationIds) {
            $exploreFurtherTags = Search::query()->resources(['terms'])->byIds($item->classificationIds)->get();
            return $exploreFurtherTags->mapWithKeys(function ($item) {
                return [$item['id'] => $item['title']];
            });
        }
    }

}

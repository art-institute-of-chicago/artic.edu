<?php

namespace App\Repositories\Api;

use App\Models\Api\DigitalLabel;
use App\Repositories\Api\BaseApiRepository;

use App\Models\Api\Search;

class DigitalLabelRepository extends BaseApiRepository
{
    const RELATED_EVENTS_PER_PAGE = 3;

    public function __construct(DigitalLabel $model)
    {
        $this->model = $model;
    }

    public function searchApi($string, $perPage = null, $page = null, $columns = [])
    {
        $search = Search::query()->search($string)->resources(['digital-labels']);

        // $results = $search->getSearch($perPage, $columns, null, $page);
        $results = $search->getPaginatedModel($perPage, \App\Models\Api\DigitalLabel::SEARCH_FIELDS);
        return $results;
    }

}

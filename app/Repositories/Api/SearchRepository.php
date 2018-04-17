<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Search;
use App\Repositories\Api\BaseApiRepository;

class SearchRepository extends BaseApiRepository
{
    public function __construct(Search $model)
    {
        $this->model = $model;
    }

    public function forSearchQuery($string, $perPage = null, $columns = [], $pageName = 'page', $page = null, $options = [] )
    {
        // Build the search query
        $search  = $this->model->search($string)->aggregationType();

        // Perform the query
        $results = $search->getSearch($perPage, $columns, $pageName, $page, $options);

        // Build metadata and results
        return (object) [
            'pagination'   => $search->paginationData,
            'aggregations' => $search->aggregationsData,
            'suggestions'  => $search->suggestionsData,
            'items'        => $results
        ];
    }

    public function multimedia($id) {
        return $this->model->query()->multimedia($id)->resources(['sections'])->getSearch(1000);
    }

    public function classroomResources($id) {
        return $this->model->query()->classroomResources($id)->resources(['sections'])->getSearch(1000);
    }

}

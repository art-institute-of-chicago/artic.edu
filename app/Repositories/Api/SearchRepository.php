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

    public function generateFilters()
    {
        // Run an empty search with all aggregations
        $query = $this->model->query()->forceEndpoint('search')->allAggregations();
        $query->getSearch(0);

        return $this->buildFilters($query->aggregationsData);
    }

    protected function buildFilters($aggregations)
    {
        $filters = [];

        foreach($aggregations as $name => $data)
        {
            switch($name) {
                case 'artist':
                    $list = collect($data->buckets)->map(function ($item) {
                        return [
                            'href' => route('collection', request()->input() + ['artist_id' => $item->key]),
                            'count' => $item->doc_count,
                            'label' => $item->name->buckets[0]->key
                        ];
                    });

                    $filters[] = [
                        'type' => 'list',
                        'title' => ucfirst($name),
                        'active' => true,
                        'listSearch' => true,
                        'list' => $list,
                        'placeholder' => "Find {$name}"
                    ];

                    break;
            }
        }

        return $filters;
    }
}

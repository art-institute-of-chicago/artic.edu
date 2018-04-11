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
        // Run an empty search to get all aggregations
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
                    // Build all list options and sort by selected (move selected at the beginning)
                    $activeList = false;
                    $list = collect($data->buckets)->map(function ($item) use ($name, &$activeList) {
                        $input = collect(explode(',', request()->input("{$name}_ids")));

                        // If input contains the ID, remove it from the URL (uncheck link)
                        if ($enabled = $input->contains($item->key)) {
                            $activeList = true; // Keep the tab open if an element is selected
                            $newInput = $input->forget($input->search($item->key));
                        } else {
                            $newInput = $input->push($item->key);
                        }

                        $route = route('collection', ["{$name}_ids" => join(',', $newInput->toArray())]);

                        return [
                            'href' => $route,
                            'count' => $item->doc_count,
                            'label' => $item->name->buckets[0]->key,
                            'enabled' => $enabled
                        ];
                    })->sortByDesc('enabled');

                    $filters[] = [
                        'type'        => 'list',
                        'title'       => ucfirst($name),
                        'active'      => $activeList,
                        'list'        => $list,
                        'listSearch'  => true,
                        'placeholder' => "Find {$name}"
                    ];

                    break;
            }
        }

        return $filters;
    }
}

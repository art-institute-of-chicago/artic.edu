<?php

namespace App\Libraries\Api\Builders;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Libraries\Api\Builders\ApiModelBuilder;

class ApiModelBuilderSearch extends ApiModelBuilder
{

    /**
     * Defines a map of [types => API class, ...]
     *
     */
    protected $typeMap = [];

    /**
     * Get a plain search request
     *
     * @param  array  $columns
     */
    public function getSearch($perPage = null, $columns = [], $pageName = 'page', $page = null)
    {
        $builder = clone $this;

        $page    = $page ?: Paginator::resolveCurrentPage($pageName);
        $perPage = $perPage ?: $this->model->getPerPage();

        $results        = $this->forPage($page, $perPage)->get($columns);
        $paginationData = $this->query->getPaginationData();

        $models = $this->extractModels($results);

        return $this->paginator($models, $paginationData->total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    protected function extractModels($results) {
        $original = clone $results;

        // Group results by type
        $resultsByType = $results->groupBy('api_model');

        // Segregate results to load a single query per entity to load them all
        $segregatedResults = $resultsByType->map(function ($collection, $type) {
            $ids = $collection->pluck('id')->toArray();
            if (isset($this->getTypeMap()[$type]))
                return $this->getTypeMap()[$type]::query()->ids($ids)->get();
        });

        // Mix them all up together
        $flatResults = collect(array_filter(array_flatten($segregatedResults)));

        // Sort results in their original order
        $sorted = $flatResults->sortBy(function($model, $key) use ($original) {
            return $original->search(function($item, $key) use ($model) {
                if (isset($this->getTypeMap()[$item->api_model])) {
                    return $this->getTypeMap()[$item->api_model] == (string) get_class($model) && $item->id == $model->id;
                }
            });

        });

        return $sorted;
    }

    protected function getTypeMap() {
        return $this->model->typeMap;
    }

}

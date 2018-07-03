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
    public function getSearch($perPage = null, $columns = [], $pageName = 'page', $page = null, $options = [])
    {
        $builder = clone $this;

        $page    = is_null($page) ? Paginator::resolveCurrentPage($pageName) : $page;
        $perPage = is_null($perPage) ? $this->model->getPerPage() : $perPage;

        $results = $this->forPage($page, $perPage)->get($columns);

        $paginationData = $results->getMetadata('pagination');
        $total = $paginationData ? $paginationData->total : $results->count();

        if (isset($options['segregated']) && $options['segregated']) {
            $models = $this->extractModels($results);
        } else {
            $models = $this->extractModelsFlat($results);
        }

        return $this->paginator($models, $total, $perPage ?: 1, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    protected function extractModelsFlat($results) {
        $original = clone $results;

        // It's more efficient to get segregated results, and then reshuffle them into the
        // original order
        $segregatedResults = $this->extractModels($results);

        // Mix them all up together
        $flatResults = collectApi(array_filter(array_flatten($segregatedResults)));

        // Sort results in their original order
        $sorted = $flatResults->sortBy(function($model, $key) use ($original) {
            return $original->search(function($item, $key) use ($model) {
                if (isset($this->getTypeMap()[$item->api_model])) {
                    return $this->getTypeMap()[$item->api_model] == (string) get_class($model) && $item->id == $model->id;
                }
            });
        })->values();

        // Preserve metadata
        $sorted->setMetadata($original->getMetadata());

        return $sorted;
    }

    protected function extractModels($results) {
        $original = clone $results;

        // Group results by type
        $resultsByType = $results->groupBy('api_model');

        // Segregate results to load a single query per entity to load them all
        $segregatedResults = $resultsByType->map(function ($collection, $type) {
            $ids = $collection->pluck('id')->toArray();
            if (isset($this->getTypeMap()[$type]))
                return $this->getTypeMap()[$type]::query()->ids($ids)->ttl($this->ttl)->get();
        });

        // Remove empty categories
        $filtered = $segregatedResults->filter(function($value, $key) {
            return !empty($value);
        });

        return $filtered;
    }

    protected function getTypeMap() {
        return $this->model->typeMap;
    }

}

<?php

namespace App\Libraries\Api\Builders;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use App\Helpers\CollectionHelpers;

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

        $page = is_null($page) ? Paginator::resolveCurrentPage($pageName) : $page;
        $perPage = is_null($perPage) ? $this->model->getPerPage() : $perPage;

        if ($columns) {
            $columns = array_merge(
                ['thumbnail', 'api_model', 'is_boosted', 'api_link', 'id', 'title', 'timestamp'],
                $columns
            );
        }
        $results = $this->forPage($page, $perPage)->get($columns);

        $paginationData = $results->getMetadata('pagination');
        $total = $paginationData ? $paginationData->total : $results->count();

        if (isset($options['do-not-extract']) && $options['do-not-extract']) {
            if (isset($options['segregated']) && $options['segregated']) {
                $models = $this->makeModels($results);
            } else {
                $models = $this->makeModelsFlat($results);
            }
        } else {
            if (isset($options['segregated']) && $options['segregated']) {
                $models = $this->extractModels($results);
            } else {
                $models = $this->extractModelsFlat($results);
            }
        }

        return $this->paginator($models, $total, $perPage ?: 1, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    /**
     * Paginate the given query and transform the Search results to the correct API models
     *
     * @param  int  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function getPaginatedModel($perPage = null, $columns = [], $pageName = 'page', $page = null)
    {
        $results = $this->getPaginated($perPage, $columns, $pageName, $page);

        $paginationData = $results->getMetadata('pagination');
        $total = $paginationData ? $paginationData->total : $results->count();

        // Transform each Search model to the correct instance using typeMap
        $hydratedModels = $results->transform(function ($item, $key) {
            return $this->getTypeMap()[$item->api_model]::hydrate([$item->toArray()])[0];
        });

        // Rebuild the paginator
        return $this->paginator($hydratedModels, $total, $perPage ?: 1, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    protected function extractModelsFlat($results)
    {
        $original = clone $results;

        // It's more efficient to get segregated results, and then reshuffle them into the
        // original order
        $segregatedResults = $this->extractModels($results);

        // Mix them all up together
        $flatResults = CollectionHelpers::collectApi(array_filter(Arr::flatten($segregatedResults)));

        // Sort results in their original order
        $sorted = $flatResults->sortBy(function ($model, $key) use ($original) {
            return $original->search(function ($item, $key) use ($model) {
                if (isset($this->getTypeMap()[$item->api_model])) {
                    return $this->getTypeMap()[$item->api_model] == (string) get_class($model) && $item->id == $model->id;
                }
            });
        })->values();

        // Preserve metadata
        $sorted->setMetadata($original->getMetadata());

        return $sorted;
    }

    protected function extractModels($results)
    {
        $original = clone $results;

        // Group results by type
        $resultsByType = $results->groupBy('api_model');

        // Segregate results to load a single query per entity to load them all
        $segregatedResults = $resultsByType->map(function ($collection, $type) {
            $ids = $collection->pluck('id')->toArray();
            $class = $this->getTypeMap()[$type];

            if (isset($class) && $class) {
                $elements = $this->getTypeMap()[$type]::query()->ids($ids);

                if ($elements && method_exists($elements, 'ttl')) {
                    $elements->ttl($this->ttl);
                }

                return $elements->get();
            }

            if (!$class) {
                return $collection; // e.g. static-pages
            }
        });

        // Remove empty categories
        $filtered = $segregatedResults->filter(function ($value, $key) {
            return !empty($value);
        });

        return $filtered;
    }

    protected function makeModelsFlat($results)
    {
        $original = clone $results;

        // It's more efficient to get segregated results, and then reshuffle them into the
        // original order
        $segregatedResults = $this->makeModels($results);

        // Mix them all up together
        $flatResults = CollectionHelpers::collectApi(array_filter(Arr::flatten($segregatedResults)));

        // Sort results in their original order
        $sorted = $flatResults->sortBy(function ($model, $key) use ($original) {
            return $original->search(function ($item, $key) use ($model) {
                if (isset($this->getTypeMap()[$item->api_model])) {
                    return $this->getTypeMap()[$item->api_model] == (string) get_class($model) && $item->id == $model->id;
                }
            });
        })->values();

        // Preserve metadata
        $sorted->setMetadata($original->getMetadata());

        return $sorted;
    }

    protected function makeModels($results)
    {
        $original = clone $results;

        // Group results by type
        $resultsByType = $results->groupBy('api_model');

        // Segregate results to load a single query per entity to load them all
        $segregatedResults = $resultsByType->map(function ($collection, $type) {
            $class = $this->getTypeMap()[$type];

            if (isset($class) && $class) {
                $elements = $collection->map(function ($searchItem) use ($class) {
                    $item = new $class($searchItem->getAttributes());

                    return $item;
                });

                return $elements;
            }

            if (!$class) {
                return $collection; // e.g. static-pages
            }
        });

        // Remove empty categories
        $filtered = $segregatedResults->filter(function ($value, $key) {
            return !empty($value);
        });

        return $filtered;
    }

    protected function getTypeMap()
    {
        return $this->model->typeMap;
    }
}

<?php

namespace App\Libraries\Api\Builders;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApiModelBuilder
{

    /**
     * The base query builder instance.
     *
     * @var App\Libraries\Api\Builders\ApiQueryBuilder;
     */
    protected $query;

    /**
     * The model being queried.
     *
     * @var \App\Libraries\Api\Models\BaseApiModel
     */
    protected $model;

    /**
     * The relationships that should be eager loaded.
     *
     * @var array
     */
    protected $eagerLoad = [];

    /**
     * The methods that should be returned from query builder.
     *
     * @var array
     */
    protected $passthru = ['runGet'];

    /**
     * Flag to indicate if we are performing a search action.
     * Endpoints are different between listings and search.
     *
     * @var array
     */
    protected $performSearch = false;

    /**
     * Variable to force to use a specific endpoint. Just save the name defined on the model
     *
     * @var string
     */
    protected $customEndpoint;

    /**
     * Applied global scopes.
     *
     * @var array
     */
    protected $scopes = [];

    /**
     * Removed global scopes.
     *
     * @var array
     */
    protected $removedScopes = [];

    /**
     * Create a new Eloquent query builder instance.
     *
     * @param  ApiQueryBuilder $query
     * @return void
     */
    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * Set a model instance for the model being queried.
     *
     * @param  \App\Libraries\Api\Models\BaseApiModel
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        // $this->query->from($model->getTable());

        return $this;
    }

    /**
     * Set the relationships that should be included.
     *
     * @param  mixed  $relations
     * @return $this
     */
    public function with($relations)
    {
        // TODO: Create a way to map a model to a string of relations.
        // This way we could just include Tag, and know that it's endpoint
        // to be added will be tags, or something different.

        $this->eagerLoad = array_merge($this->eagerLoad, $relations);

        return $this;
    }

    /**
     * Return counting data from the request.
     * TODO: Implement it for the API. Bypassing for the moment.
     *
     * @param  mixed  $relations
     * @return $this
     */
    public function withCount($relations)
    {
        return $this;
    }

    /**
     * Add a basic where clause to the query.
     *
     * @param  string|array|\Closure  $column
     * @param  string  $operator
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        $this->query->where(...func_get_args());

        return $this;
    }

    /**
     * Perform a search
     *
     * @param  string  $search
     * @return $this
     */
    public function search($search)
    {
        $this->query->search(...func_get_args());
        $this->performSearch = true;

        return $this;
    }

    /**
     * Perform a raw ES search
     *
     * @param  array $search
     * @return $this
     */
    public function rawSearch($search)
    {
        $this->query->rawSearch(...func_get_args());
        $this->performSearch = true;

        return $this;
    }

    /**
     * Perform a raw ES query
     *
     * @param  array $params
     * @return $this
     */
    public function rawQuery($params)
    {
        $this->query->rawQuery(...func_get_args());
        $this->performSearch = true;

        return $this;
    }

    /**
     * Add aggregations to the raw ES search
     *
     * @param  array $aggregations
     * @return $this
     */
    public function aggregations($aggregations)
    {
        $this->query->aggregations(...func_get_args());

        return $this;
    }

    /**
     * When searching filter by specific resources
     *
     * @param  array $resources
     * @return $this
     */
    public function resources(array $resources)
    {
        $this->query->resources($resources);

        return $this;
    }

    /**
     * Filter elements by specific ID's
     *
     * @param  array $ids
     * @return $this
     */
    public function ids(array $ids)
    {
        // Remove slugs from ID-SLUG type of id's
        // $ids = array_map(function($id) { return (integer) $id; }, $ids);

        $this->query->ids($ids);

        return $this;
    }

    /**
     * Include fields at the results
     *
     * @param  array $include
     * @return $this
     */
    public function include(array $inclusions)
    {
        $this->query->include($inclusions);

        return $this;
    }

    /**
     * Find a model by its primary key.
     *
     * @param  mixed  $id
     * @param  array  $columns
     */
    public function find($id, $columns = [])
    {
        if (is_array($id) || $id instanceof Arrayable) {
            return $this->findMany($id, $columns);
        }

        return $this->findSingle($id, $columns);
    }

    /**
     * Find a model by its primary key, return exception if empty.
     *
     * @param  mixed  $id
     * @param  array  $columns
     */
    public function findOrFail($id, $columns = [])
    {
        $result = $this->find($id, $columns);

        if (is_array($id)) {
            if (count($result) == count(array_unique($id))) {
                return $result;
            }
        } elseif (! is_null($result)) {
            return $result;
        }

        throw (new ModelNotFoundException)->setModel(
            get_class($this->model), $id
        );
    }

    public function findSingle($id, $columns = [])
    {
        $builder = clone $this;

        // Remove slugs from ID-SLUG type of id's
        // $id = (integer) $id;

        // Eager load relationships
        if ($result = $builder->getSingle($id, $columns)) {
            $result = $builder->eagerLoadRelations([$result]);
        }

        return $builder->getModel()->newCollection($result)->first();
    }

    public function findMany($ids, $columns = [])
    {
        if (empty($ids)) {
            return $this->model->newCollection();
        }

        return $this->ids($ids)->get($columns);
    }

    /**
     * Execute the query and return a collection of results
     *
     * @param  array  $columns
     */
    public function get($columns = [])
    {
        $builder = clone $this;

        if (count($models = $builder->getModels($columns)) > 0) {
            $models = $builder->eagerLoadRelations($models);
        }

        return $builder->getModel()->newCollection($models);
    }


    /**
     * Execute the query and return a raw response
     *
     * @param  array  $columns
     */
    public function getRaw($columns = [])
    {
        $builder = clone $this;

        return $this->query->getRaw($columns, $this->getEndpoint($this->resolveCollectionEndpoint()))->all();
    }

    /**
     * Get the hydrated models
     *
     * @param  array  $columns
     */
    public function getModels($columns = [])
    {
        $results = $this->query->get($columns, $this->getEndpoint($this->resolveCollectionEndpoint()));
        $models  = $this->model->hydrate($results->all());

        // Preserve metadata after hydrating the collection
        return collectApi($models)->setMetadata($results->getMetadata());
    }

    /**
     * Get a plain search request
     *
     * @param  array  $columns
     */
    public function getSearch($perPage = null, $columns = [], $pageName = 'page', $page = null)
    {
        $builder = clone $this;

        $page    = is_null($page) ? Paginator::resolveCurrentPage($pageName) : $page;
        $perPage = is_null($perPage) ? $this->model->getPerPage() : $perPage;

        $results = $this->forPage($page, $perPage)->get($columns);

        $paginationData = $results->getMetadata('pagination');
        $total = $paginationData ? $paginationData->total : $results->count();

        // Extract IDS
        $ids = $results->pluck('id')->toArray();

        // Load the actual models using the IDS returned by search
        if (empty($ids)) {
            $models = collectApi();
        } else {
            $models = $this->model->newQuery()->ids($ids)->get();
        }

        // Sort them by the original ids listing
        $sorted = $models->sortBy(function($model, $key) use ($ids) {
            return collectApi($ids)->search(function($id, $key) use ($model) {
                return $id == $model->id;
            });
        });

        // Preserve original metadata
        $sorted->setMetadata($results->getMetadata());

        return $this->paginator($sorted, $total, $perPage ?: 1, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    /**
     * Eager load the relationships for the models.
     * On this case just a flat include, not nested queries because
     * we get all id's to be loaded on the first request to the parent model
     *
     * @param  array  $models
     * @return array
     */
    public function eagerLoadRelations($models)
    {
        // Preserve metadata when loading relationships
        if ($models instanceof ApiCollection) {
            $metadata = $models->getMetadata();
        }

        foreach ($this->eagerLoad as $name) {
            $models = $this->eagerLoadRelation($models, $name);
        }

        return isset($metadata) ? $models->setMetadata($metadata) : $models;
    }

    /**
     * Eagerly load the relationship on a set of models.
     *
     * @param  array  $models
     * @param  string  $name
     * @return array
     */
    protected function eagerLoadRelation(array $models, $name)
    {
        foreach ($models as $model) {
            // For each model get the relationship
            $relation = $model->{$name}();

            // Set the relationship loading the data from the API
            // this will generate N + 1 calls in total
            // improve later using real eager loading to
            // reduce the number of calls to 1 + relationships_number
            if ($relation)
                $model->setRelation($name, $relation->getEager());
        }

        return $models;
    }

    /**
     * Execute the query and return a single element
     *
     * @param  array  $columns
     */
    public function getSingle($id, $columns = [])
    {
        $builder = clone $this;

        $endpoint = $this->getEndpoint($this->resolveResourceEndpoint(), ['id' => $id]);

        $result = $this->model->hydrate(
            $this->query->get($columns, $endpoint)->all()
        );

        return $result[0];
    }

    /**
     * Paginate the given query.
     *
     * @param  int  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function getPaginated($perPage = null, $columns = [], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->model->getPerPage();

        $results        = $this->forPage($page, $perPage)->get($columns);
        $paginationData = $results->getMetadata('pagination');
        $total = $paginationData ? $paginationData->total : $results->count();

        return $this->paginator($results, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    /**
     * Paginate the given query.
     *
     * @param  int  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *
     * @throws \InvalidArgumentException
     */
    public function paginate($perPage = null, $columns = [], $pageName = 'page', $page = null)
    {
        if ($this->performSearch) {
            return $this->getSearch($perPage, $columns, $pageName, $page);
        } else {
            return $this->getPaginated($perPage, $columns, $pageName, $page);
        }
    }

    protected function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            $options
        );
    }

    /**
     * Get the model instance being queried.
     *
     * @return string
     */
    public function getEndpoint($name, $params = [])
    {
        return $this->model->parseEndpoint($name, $params);
    }

    /**
     * Force to use a specific endpoint
     *
     * @return string
     */
    public function forceEndpoint($name)
    {
        $this->customEndpoint = $name;

        return $this;
    }

    /**
     * Resolve endpoint. Because search and listing contains different ones
     * We will check if we are calling a search, and use that endpoint in that case
     *
     * @return string
     */
    public function resolveCollectionEndpoint()
    {
        if ($this->customEndpoint) {
            return $this->customEndpoint;
        } else {
            return $this->performSearch ? 'search' : 'collection';
        }
    }

    /**
     * Resolve single element endpoint
     *
     * @return string
     */
    public function resolveResourceEndpoint()
    {
        return $this->customEndpoint ?? 'resource';
    }

    /**
     * Get the model instance being queried.
     *
     * @return \App\Libraries\Api\Models\BaseApiModel;
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * TODO: Apply scopes before running a passthrough
     */
    public function toBase()
    {
        return $this;
    }

    /**
     * Apply the given scope on the current builder instance.
     *
     * @param  callable  $scope
     * @param  array  $parameters
     * @return mixed
     */
    protected function callScope(callable $scope, $parameters = [])
    {
        array_unshift($parameters, $this);
        $result = $scope(...array_values($parameters)) ?? $this;
        return $result;
    }

    /**
     * Dynamically handle calls into the query instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (method_exists($this->model, $scope = 'scope'.ucfirst($method))) {
            return $this->callScope([$this->model, $scope], $parameters);
        }

        if (in_array($method, $this->passthru)) {
            return $this->query->{$method}(...$parameters);
        }

        $this->query->{$method}(...$parameters);

        return $this;
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->query->$key;
    }


}

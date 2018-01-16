<?php

namespace App\Libraries\Api\Builders;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

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
    protected $passthru = [];

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
     * Add a basic where clause to the query.
     *
     * @param  string|array|\Closure  $column
     * @param  string  $operator
     * @param  mixed  $value
     * @param  string  $boolean
     * @return $this
     */
    public function ids($ids)
    {
        $this->query->ids(...func_get_args());

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

    public function findSingle($id, $columns = [])
    {
        return $this->getSingle($id, $columns);
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

        // if (count($models = $builder->getModels($columns)) > 0) {
        //     $models = $builder->eagerLoadRelations($models);
        // }

        $models = $builder->getModels($columns);

        return $builder->getModel()->newCollection($models);
    }

    /**
     * Get the hydrated models
     *
     * @param  array  $columns
     */
    public function getModels($columns = [])
    {
        return $this->model->hydrate(
            $this->query->get($columns, $this->getEndpoint('collection'))->all()
        );
    }

    /**
     * Execute the query and return a single element
     *
     * @param  array  $columns
     */
    public function getSingle($id, $columns = [])
    {
        $builder = clone $this;

        $endpoint = $this->getEndpoint('resource', ['id' => $id]);

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
    public function paginate($perPage = null, $columns = [], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->model->getPerPage();

        $results        = $this->forPage($page, $perPage)->get($columns);
        $paginationData = $this->query->getPaginationData();

        return $this->paginator($results, $paginationData->total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
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
     * @return \App\Libraries\Api\Models\BaseApiModel
     */
    public function getEndpoint($name, $params = [])
    {
        return $this->model->parseEndpoint($name, $params);
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
            return $this->toBase()->{$method}(...$parameters);
        }

        $this->query->{$method}(...$parameters);

        return $this;
    }


}

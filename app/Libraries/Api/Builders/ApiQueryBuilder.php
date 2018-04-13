<?php

namespace App\Libraries\Api\Builders;

use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Container\Container;

class ApiQueryBuilder {

    /**
     * All of the available clause operators.
     *
     * @var array
     */
    public $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>'
    ];

    /**
     * The orderings for the query.
     *
     * @var array
     */
    public $orders;

    /**
     * The maximum number of records to return.
     *
     * @var int
     */
    public $limit;

    /**
     * The number of records to skip.
     *
     * @var int
     */
    public $offset;


    /**
     * The current page number
     *
     * @var int
     */
    public $page;

    /**
     * The database query grammar instance.
     *
     * @var \Illuminate\Database\Query\Grammars\Grammar
     */
    public $grammar;

    /**
     * The columns that should be returned.
     *
     * @var array
     */
    public $columns;

    /**
     * The ids of the records that should be returned.
     *
     * @var array
     */
    public $ids = [];

    /**
     * The where constraints for the query.
     *
     * @var array
     */
    public $wheres = [];

    /**
     * Search constraints for the query.
     *
     * @var string
     */
    public $searchText;

    /**
     * Search parameters for a raw ES query.
     *
     * @var array
     */
    public $searchParameters = [];


    /**
     * Completely raw ES query.
     *
     * @var array
     */
    public $rawQuery = [];


    /**
     * Aggregations parameters for a raw ES query.
     *
     * @var array
     */
    public $aggregationParameters = [];

    /**
     * Search specific resources. Useful only for general searches
     *
     * @var array
     */
    public $searchResources = [];

    /**
     * Pagination data saved after a request
     */
    public $paginationData;

    /**
     * Aggregation data saved after a request
     */
    public $aggregationsData;

    /**
     * Suggestion data saved after a request
     */
    public $suggestionsData;


    public function __construct($connection, $grammar = null)
    {
        $this->connection = $connection;
        $this->grammar = $grammar ?: $connection->getQueryGrammar();
    }

    /**
     * Bypass whereNotIn function until it's implemented on the API
     *
     */
    public function whereNotIn($column, $values, $boolean = 'and')
    {
        return $this;
    }

    public function whereIn($column, $values, $boolean = 'and', $not = false)
    {
        if ($column == 'id') {
            $this->ids($values);
            return $this;
        } else {
            throw new \Exception("whereIn function has been defined only for IDS at the API Query Builder");
        }
    }

    /**
     * Add a basic where clause to the query.
     *
     * @param  string|array|\Closure  $column
     * @param  string|null  $operator
     * @param  mixed   $value
     * @param  string  $boolean
     * @return $this
     */
    public function where($column, $operator = null, $value = null, $boolean = 'and')
    {
        // If the column is an array, we will assume it is an array of key-value pairs
        // and can add them each as a where clause. We will maintain the boolean we
        // received when the method was called and pass it into the nested where.
        if (is_array($column)) {
            throw new \Exception("where function should be called with 1 level of nesting. No arrays.");
        }

        // Here we will make some assumptions about the operator. If only 2 values are
        // passed to the method, we will assume that the operator is an equals sign
        // and keep going. Otherwise, we'll require the operator to be passed in.
        // list($value, $operator) = $this->prepareValueAndOperator(
        //     $value, $operator, func_num_args() == 2
        // );

        // If the given operator is not found in the list of valid operators we will
        // assume that the developer is just short-cutting the '=' operators and
        // we will set the operators to '=' and set the values appropriately.
        if ($this->invalidOperator($operator)) {
            list($value, $operator) = [$operator, '='];
        }

        // If the value is "null", we will just assume the developer wants to add a
        // where null clause to the query. So, we will allow a short-cut here to
        // that method for convenience so the developer doesn't have to check.
        // if (is_null($value)) {
        //     return $this->whereNull($column, $boolean, $operator !== '=');
        // }

        // If the column is making a JSON reference we'll check to see if the value
        // is a boolean. If it is, we'll add the raw boolean string as an actual
        // value to the query to ensure this is properly handled by the query.
        // if (Str::contains($column, '->') && is_bool($value)) {
        //     $value = new Expression($value ? 'true' : 'false');
        // }

        // Now that we are working with just a simple query we can put the elements
        // in our array and add the query binding to our array of bindings that
        // will be bound to each SQL statements when it is finally executed.
        $type = 'Basic';

        $this->wheres[] = compact(
            'type', 'column', 'operator', 'value', 'boolean'
        );

        // if (! $value instanceof Expression) {
        //     $this->addBinding($value, 'where');
        // }

        return $this;
    }

    /**
     * Add an "order by" clause to the query.
     *
     * @param  string  $column
     * @param  string  $direction
     * @return $this
     */
    public function orderBy($column, $direction = 'asc')
    {
        $this->orders[] = [
            $column => ['order' => strtolower($direction) == 'asc' ? 'asc' : 'desc']
        ];

        return $this;
    }

    /**
     * Add an "ids" clause to the query. This will bring only records with these ids
     *
     * @param  string  $column
     * @param  string  $direction
     * @return $this
     */
    public function ids($ids = [])
    {
        if (!empty($ids)) {
            $this->ids = $ids;
        }

        return $this;
    }

    /**
     * Paginate the given query into a simple paginator.
     *
     * @param  int  $perPage
     * @param  array  $columns
     * @param  string  $pageName
     * @param  int|null  $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage = 15, $columns = [], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $results = $this->forPage($page, $perPage)->get($columns);

        $paginationData = $this->getPaginationData();
        $total = $paginationData ? $paginationData->total : $results->count();

        $data = $results['body']->data;

        return $this->paginator($data, $total, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  array  $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            $options
        );

        // return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
        //     'items', 'total', 'perPage', 'currentPage', 'options'
        // ));
    }

    /**
     * Set the limit and offset for a given page.
     *
     * @param  int  $page
     * @param  int  $perPage
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function forPage($page, $perPage = 15)
    {
        $this->page = $page;

        return $this->skip(($page - 1) * $perPage)->take($perPage);
    }

    /**
     * Alias to set the "offset" value of the query.
     *
     * @param  int  $value
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function skip($value)
    {
        return $this->offset($value);
    }

    /**
     * Set the "offset" value of the query.
     *
     * @param  int  $value
     * @return $this
     */
    public function offset($value)
    {
        $this->offset = max(0, $value);

        return $this;
    }

    /**
     * Alias to set the "limit" value of the query.
     *
     * @param  int  $value
     * @return \Illuminate\Database\Query\Builder|static
     */
    public function take($value)
    {
        return $this->limit($value);
    }


    /**
     * Set the "limit" value of the query.
     *
     * @param  int  $value
     * @return $this
     */
    public function limit($value)
    {
        if ($value >= 0) {
            $this->limit = $value;
        }

        return $this;
    }

    /**
     * Search for specific resources
     *
     * @param  string  $search
     * @return $this
     */
    public function resources($resources)
    {
        $this->searchResources = $resources;

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
        $this->searchText = empty($search) ? null : $search;

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
        $this->searchParameters = array_merge_recursive($this->searchParameters, $search);

        return $this;
    }

    /**
     * Perform a completely raw ES query
     *
     * @param  array $search
     * @return $this
     */
    public function rawQuery($search)
    {
        $this->rawQuery = $search;

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
        $this->aggregationParameters = array_merge_recursive($this->aggregationParameters, $aggregations);

        return $this;
    }

    /**
     * Execute a get query and setup pagination data
     *
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function get($columns = [], $endpoint = null)
    {
        $original = $this->columns;

        if (is_null($original)) {
            $this->columns = $columns;
        }

        $results = $this->runGet($endpoint);

        $this->paginationData = $results->body->pagination ?? null;
        $this->aggregationsData = $results->body->aggregations ?? null;
        $this->suggestionsData = $results->body->suggest ?? null;

        $this->columns = $original;

        // If it's a single element return as a collection with 1 element
        if (is_array($results->body->data)) {
            return collect($results->body->data);
        } else {
            return collect([$results->body->data]);
        }
    }

    /**
     * Execute a get query and return a raw response
     *
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function getRaw($columns = [], $endpoint = null)
    {
        $original = $this->columns;

        if (is_null($original)) {
            $this->columns = $columns;
        }

        $results = $this->runGet($endpoint);

        if (is_array($results->body)) {
            return collect($results->body);
        } else {
            return collect([$results->body]);
        }
    }

    public function getPaginationData() {
        return $this->paginationData;
    }

    /**
     * Build and execute against the API connection a GET call
     *
     * @return array
     */
    public function runGet($endpoint)
    {
        return $this->connection->get($endpoint, $this->resolveParameters());
    }

    /**
     * Use grammar to generate all parameters from the scopes as an array
     *
     * @return string
     */
    public function resolveParameters()
    {
        return $this->grammar->compileParameters($this);
    }

    /**
     * Determine if the given operator is supported.
     *
     * @param  string  $operator
     * @return bool
     */
    protected function invalidOperator($operator)
    {
        return !in_array(strtolower($operator), $this->operators, true);
    }

}

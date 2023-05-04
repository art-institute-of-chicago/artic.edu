<?php

namespace App\Libraries\Api\Builders;

use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Libraries\Api\Builders\Grammar\MsearchGrammar;
use App\Libraries\Api\Builders\Grammar\SearchGrammar;
use App\Helpers\CollectionHelpers;

class ApiQueryBuilder
{
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
     * Whether to apply boosting or not
     *
     * @var boolean
     */
    public $boost = true;

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
     * The Cache TTL for this specific query builder
     *
     * @var array
     */
    public $ttl;

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
     * The list of extra fields to be included
     *
     * @var array
     */
    public $include = [];

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
        }

        throw new \Exception('whereIn function has been defined only for IDS at the API Query Builder');
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
            throw new \Exception('where function should be called with 1 level of nesting. No arrays.');
        }

        // If the given operator is not found in the list of valid operators we will
        // assume that the developer is just short-cutting the '=' operators and
        // we will set the operators to '=' and set the values appropriately.
        if ($this->invalidOperator($operator)) {
            [$value, $operator] = [$operator, '='];
        }

        // Now that we are working with just a simple query we can put the elements
        // in our array and add the query binding to our array of bindings that
        // will be bound to each SQL statements when it is finally executed.
        $type = 'Basic';

        $this->wheres[] = compact(
            'type',
            'column',
            'operator',
            'value',
            'boolean'
        );

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
     * Add an "includes" clause to the query. This will add those attributes
     *
     * @return $this
     */
    public function include($inclusions = [])
    {
        if (!empty($inclusions)) {
            $this->include = $inclusions;
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
     * Set the "boost" value of the query.
     *
     * @param  boolean  $value
     * @return $this
     */
    public function boost($value = true)
    {
        $this->boost = $value;

        return $this;
    }

    /**
     * Search for specific resources
     *
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

        // If we got anything different than a HIT return the body
        if (isset($results->status) && $results->status != 200) {
            if (isset($results->body)) {
                return $results->body;
            }

            return $results;
        }

        $this->columns = $original;

        if (is_array($results->body)) {
            // If it's an msearch result return first element
            $collection = CollectionHelpers::collectApi($results->body[0]->data);
        } elseif (is_array($results->body->data)) {
            // If it's a single element return as a collection with 1 element
            $collection = CollectionHelpers::collectApi($results->body->data);
        } else {
            $collection = CollectionHelpers::collectApi([$results->body->data]);
        }

        $collection = $this->getSortedCollection($collection);

        $collection->setMetadata([
            'pagination' => $results->body->pagination ?? null,
            'aggregations' => $results->body->aggregations ?? null,
            'suggestions' => $results->body->suggest ?? null
        ]);

        return $collection;
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
            $collection = CollectionHelpers::collectApi($results->body);
        } else {
            $collection = CollectionHelpers::collectApi([$results->body]);
        }

        $collection = $this->getSortedCollection($collection);

        $collection->setMetadata([
            'pagination' => $results->body->pagination ?? null,
            'aggregations' => $results->body->aggregations ?? null,
            'suggestions' => $results->body->suggest ?? null
        ]);

        return $collection;
    }

    public function getPaginationData()
    {
        return $this->paginationData;
    }

    /**
     * Build and execute against the API connection a GET call
     *
     * @return array
     */
    public function runGet($endpoint)
    {
        $grammar = null;

        if (Str::endsWith($endpoint, '/msearch')) {
            $grammar = new MsearchGrammar();
        } elseif (Str::endsWith($endpoint, '/search')) {
            $grammar = new SearchGrammar();
        }

        return $this->connection->ttl($this->ttl)->get($endpoint, $this->resolveParameters($grammar));
    }

    /**
     * Use grammar to generate all parameters from the scopes as an array
     *
     * @return string
     */
    public function resolveParameters($grammar = null)
    {
        if ($grammar) {
            return $grammar->compileParameters($this);
        }

        return $this->grammar->compileParameters($this);
    }

    /**
     * Set a specific Caching TTL for this request
     *
     * @return array
     */
    public function ttl($ttl = null)
    {
        $this->ttl = $ttl;

        return $this;
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

    /**
     * WEB-1626: If this was an `ids` query, reorder results to match `ids`.
     */
    private function getSortedCollection($collection)
    {
        if (empty($this->ids)) {
            return $collection;
        }

        return $collection->sort(function ($a, $b) use ($collection) {
            if (!isset($a->id) || !isset($b->id)) {
                return 0;
            }

            $ia = array_search($a->id, $this->ids);
            $ib = array_search($b->id, $this->ids);

            if ($ia === $ib) {
                return 0;
            }

            return ($ia < $ib) ? -1 : 1;
        });
    }
}

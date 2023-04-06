<?php

namespace App\Libraries\Api\Builders\Grammar;

use App\Libraries\Api\Builders\ApiQueryBuilder;

class AicGrammar
{
    protected $selectComponents = [
        'wheres',
        'limit',
        'offset',
        'boost',
        'page',
        'orders',
        'ids',
        'columns',
        'include',
        'searchText',
        'searchParameters',
        'searchResources',
        'aggregationParameters',
        'rawQuery'
    ];

    /**
     * Compile all components into API parameters.
     *
     * @return string
     */
    public function compileParameters(ApiQueryBuilder $query)
    {
        $original = $query->columns;

        // To compile the query, we'll spin through each component of the query and
        // see if that component exists. If it does we'll just call the compiler
        // function for the component which is responsible for making the parameters
        $compiled = $this->compileComponents($query);

        $query->columns = $original;

        return $compiled;
    }

    /**
     * Compile the components necessary for a select clause.
     *
     * @param  ApiQueryBuilder $query
     * @return array
     */
    protected function compileComponents($query)
    {
        $parameters = [];

        foreach ($this->selectComponents as $component) {
            // To compile the query, we'll spin through each component of the query and
            // see if that component exists. If it does we'll just call the compiler
            // function for the component which is responsible for making the parameter/s.
            if (!is_null($query->{$component})) {
                $method = 'compile' . ucfirst($component);

                $parameters = array_merge($parameters, $this->{$method}($query, $query->{$component}));
            }
        }

        return $parameters;
    }

    /**
     * Compile the "where" portions of the query.
     *
     * @param  ApiQueryBuilder $query
     * @return string
     */
    protected function compileWheres($query)
    {
        return [];
    }

    /**
     * Compile the "columns" portions of the query. This translates to 'fields'
     * which are the columns the API will return.
     *
     * @param  ApiQueryBuilder $query
     * @return array
     */
    protected function compileColumns($query, $columns)
    {
        return empty($columns) ? [] : ['fields' => join(',', $columns)];
    }

    /**
     * Compile the "include" portions of the query.
     *
     * @param  ApiQueryBuilder $query
     * @return array
     */
    protected function compileInclude($query, $columns)
    {
        return empty($columns) ? [] : ['include' => join(',', $columns)];
    }

    /**
     * Compile the "ids" portions of the query. This will filter by an IDs array
     *
     * @param  ApiQueryBuilder $query
     * @return array
     */
    protected function compileIds($query, $ids)
    {
        return empty($ids) ? [] : ['ids' => join(',', $ids)];
    }

    protected function compileSearchResources($query, $resources)
    {
        return empty($resources) ? [] : ['resources' => join(',', $resources)];
    }

    protected function compileSearchText($query, $text)
    {
        if ($text) {
            return ['q' => $text];
        }

        return [];
    }

    protected function compileSearchParameters($query, array $elasticParameters)
    {
        return empty($elasticParameters) ? [] : ['query' => $elasticParameters];
    }

    protected function compileRawQuery($query, array $rawQuery)
    {
        return empty($rawQuery) ? [] : $rawQuery;
    }

    protected function compileAggregationParameters($query, array $aggregations)
    {
        return empty($aggregations) ? [] : ['aggregations' => $aggregations];
    }

    protected function compileOrders($query, $order)
    {
        return empty($order) ? [] : ['sort' => $order];
    }

    protected function compileLimit($query, $limit)
    {
        return [
            'limit' => $limit,
            'size' => $limit // Elasticsearch search parameter for limiting
        ];
    }

    protected function compileOffset($query, $offset)
    {
        return [
            'offset' => $offset,
            'from' => $offset // Elasticsearch search parameter for offset
        ];
    }

    protected function compileBoost($query, $boost)
    {
        return [];
    }

    protected function compilePage($query, $page)
    {
        return ['page' => $page];
    }
}

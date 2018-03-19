<?php

namespace App\Libraries\Api\Builders\Grammar;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Libraries\Api\Builders\ApiQueryBuilder;

class AicGrammar
{
    protected $selectComponents = [
        'wheres',
        'limit',
        'offset',
        'page',
        'orders',
        'ids',
        'columns',
        'searchText',
        'searchParameters',
        'searchResources',
        'aggregationParameters'
    ];

    /**
     * Compile all components into API parameters.
     *
     * @param  ApiQueryBuilder $query
     * @return string
     */
    public function compileParameters(ApiQueryBuilder $query)
    {
        $original = $query->columns;

        // To compile the query, we'll spin through each component of the query and
        // see if that component exists. If it does we'll just call the compiler
        // function for the component which is responsible for making the parameters
        $compiled = $this->compileComponents($query);

        // \Log::info("Compiled parameters for this call are:");
        // \Log::info(print_r($compiled, true));

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
            if (! is_null($query->$component)) {
                $method = 'compile'.ucfirst($component);

                $parameters = array_merge($parameters, $this->$method($query, $query->$component));
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

        // TODO: Define how to filter by field values (not in api for now without search)
        // return ['wheres' => ''];
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
        if ($text)
            return ['q' => $text];
        else
            return [];
    }

    protected function compileSearchParameters($query, array $elasticParameters)
    {
        return empty($elasticParameters) ? [] : ['query' => $elasticParameters];
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
            'size'  => $limit   // Elasticsearch search parameter for limiting
        ];
    }

    protected function compileOffset($query, $offset)
    {
        return [
            'offset' => $offset,
            'from'   => $offset // Elasticsearch search parameter for offset
        ];
    }

    protected function compilePage($query, $page)
    {
        return ['page' => $page];
    }

}

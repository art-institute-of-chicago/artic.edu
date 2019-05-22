<?php

namespace App\Libraries\Api\Builders\Grammar;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Libraries\Api\Builders\ApiQueryBuilder;

class MsearchGrammar extends AicGrammar
{

    /**
     * Compile the components necessary for a select clause.
     *
     * @param  ApiQueryBuilder $query
     * @return array
     */
    protected function compileComponents($query)
    {
        return [parent::compileComponents($query)];
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
        return empty($columns) ? [] : ['fields' => $columns];
    }
}

<?php

namespace App\Libraries\Api\Builders\Grammar;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Libraries\Api\Builders\ApiQueryBuilder;

class SearchGrammar extends AicGrammar
{

    protected function compileBoost($query, $boost)
    {
        return [
            'boost' => $boost,
        ];
    }

}

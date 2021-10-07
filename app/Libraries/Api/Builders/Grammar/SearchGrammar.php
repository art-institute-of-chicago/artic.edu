<?php

namespace App\Libraries\Api\Builders\Grammar;

class SearchGrammar extends AicGrammar
{
    protected function compileBoost($query, $boost)
    {
        return [
            'boost' => $boost,
        ];
    }
}

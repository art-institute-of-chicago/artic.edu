<?php

namespace App\Helpers;

use Illuminate\Support\Arr;

class QueryHelpers
{
    public static function extractAggregation($aggregations, $names)
    {
        if (!is_array($names)) {
            $names = [$names];
        }

        $count = 0;
        foreach ($names as $name) {
            $element = Arr::first($aggregations, function ($value) use ($name) {
                return $value->key == $name;
            });

            $element ? $count += $element->doc_count : null;
        }

        return $count > 0 ? $count : null;
    }

    public static function escape_like(string $value, string $char = '\\'): string
    {
        return str_replace(
            [$char, '%', '_'],
            [$char . $char, $char . '%', $char . '_'],
            $value
        );
    }
}

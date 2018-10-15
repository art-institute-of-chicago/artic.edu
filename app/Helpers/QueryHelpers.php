<?php

if (!function_exists('extractAggregation')) {
    function extractAggregation($aggregations, $names)
    {
        if (!is_array($names)) {
            $names = [$names];
        }

        $count = 0;
        foreach ($names as $name) {
            $element = array_first($aggregations, function($value) use ($name) {
                return $value->key == $name;
            });

            $element ? $count += $element->doc_count : null;
        }

        return $count > 0 ? $count : null;
    }
}

if (!function_exists('escape_like')) {
    function escape_like(string $value, string $char = '\\'): string
    {
        return str_replace(
            [$char, '%', '_'],
            [$char.$char, $char.'%', $char.'_'],
            $value
        );
    }
}

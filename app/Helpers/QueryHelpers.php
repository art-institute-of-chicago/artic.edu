<?php

if (!function_exists('extractAggregation')) {
    function extractAggregation($aggregations, $name)
    {
        $element = array_first($aggregations, function($value) use ($name) {
            return $value->key == $name;
        });

        return $element ? $element->doc_count : null;
    }
}

?>

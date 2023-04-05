<?php

namespace App\Helpers;

class CollectionHelpers
{
    /**
     * Create a collection from the given value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Support\Collection
     */
    public static function collectApi($value = null)
    {
        return new \App\Libraries\Api\Models\ApiCollection($value);
    }
}

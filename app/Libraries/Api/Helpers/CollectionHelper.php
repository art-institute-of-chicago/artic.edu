<?php

if (! function_exists('collectApi')) {
    /**
     * Create a collection from the given value.
     *
     * @param  mixed  $value
     * @return \Illuminate\Support\Collection
     */
    function collectApi($value = null)
    {
        return new \App\Libraries\Api\Models\ApiCollection($value);
    }
}

?>

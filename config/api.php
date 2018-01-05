<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default API Base URL
    |--------------------------------------------------------------------------
    |
    | It will be used by our API consumer to augment our Eloquent models with
    | data coming from their sources.
    |
    */

    'base_uri' => env('API_BASE_URI', 'http://aggregator-data-test.artic.edu'),
];

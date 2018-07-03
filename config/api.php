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

    /*
    |--------------------------------------------------------------------------
    | Force API requests to use POST
    |--------------------------------------------------------------------------
    |
    | Force API calls to use a specific verb.
    |
    | Possible options: 'GET', 'POST'
    |
    */

    'force_verb' => env('API_FORCE_VERB', false),

    /*
    |--------------------------------------------------------------------------
    | API caching
    |--------------------------------------------------------------------------
    |
    */

    'cache_enabled' => env('API_CACHE_ENABLED', false),
    'cache_ttl'     => env('API_CACHE_TTL', 60 * 30), //Half an hour default
    'cache_version' => env('API_CACHE_VERSION', 1),
    'logger' => env('API_LOGGER', false)
];

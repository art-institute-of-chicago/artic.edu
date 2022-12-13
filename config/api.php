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

    'base_uri' => env('API_BASE_URI', 'https://api.artic.edu'),

    /*
    |--------------------------------------------------------------------------
    | Public API Base URL
    |--------------------------------------------------------------------------
    |
    | Used on the frontend to support collection autosuggest.
    |
    */

    'public_uri' => env('API_PUBLIC_URI', 'https://api.artic.edu'),

    /*
    |--------------------------------------------------------------------------
    | Force API requests to use POST
    |--------------------------------------------------------------------------
    |
    | Force API calls to use a specific verb.
    |
    | Possible options: 'GET' or 'POST'; anything else will have no effect
    |
    */

    'force_verb' => env('API_FORCE_VERB', false),

    /*
    |--------------------------------------------------------------------------
    | API caching
    |--------------------------------------------------------------------------
    |
    */

    'cache_enabled' => (bool) env('API_CACHE_ENABLED', false),
    'cache_ttl' => env('API_CACHE_TTL', 30 * 60), //Half an hour default
    'cache_version' => env('API_CACHE_VERSION', 1),
    'cache_buster' => env('API_CACHE_BUSTER'),

    'logger' => (bool) env('API_LOGGER', false),

    'token' => env('API_TOKEN', null)
];

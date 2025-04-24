<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Twill Dashboard configuration
    |--------------------------------------------------------------------------
    |
    | This array allows you to provide the package with your configuration
    | for the dashboard.
    |
     */
    'modules' => [
        'events' => [
            'name' => 'events',
            'routePrefix' => 'exhibitionsEvents',
            'count' => true,
            'create' => true,
            'search' => true,
            'activity' => true,
            'draft' => true,
        ],
        'articles' => [
            'name' => 'articles',
            'routePrefix' => 'collection.articlesPublications',
            'count' => true,
            'create' => true,
            'search' => true,
            'activity' => true,
            'drafts' => true,
        ],
        'exhibitions' => [
            'name' => 'exhibitions',
            'routePrefix' => 'exhibitionsEvents',
            'count' => false,
            'create' => false,
            'search' => true,
            'search_fields' => ['title', 'datahub_id'],
            'activity' => true,
            'drafts' => false,
        ],
        'artists' => [
            'name' => 'artists',
            'routePrefix' => 'collection',
            'count' => false,
            'create' => false,
            'search' => true,
            'search_fields' => ['title', 'datahub_id'],
            'activity' => true,
            'drafts' => false,
        ],
        'genericPages' => [
            'label' => 'Generic pages',
            'label_singular' => 'Generic page',
            'name' => 'genericPages',
            'routePrefix' => 'generic',
            'count' => true,
            'create' => true,
            'search' => true,
            'activity' => true,
            'drafts' => true,
        ],
        'highlights' => [
            'label' => 'Highlights',
            'label_singular' => 'Highlight',
            'name' => 'highlights',
            'routePrefix' => 'collection',
            'count' => true,
            'create' => true,
            'search' => true,
            'activity' => true,
            'drafts' => true,
        ],
    ],
    'analytics' => [
        'enabled' => true,
        'property_id' => env('ANALYTICS_PROPERTY_ID'),
        'service_account_credentials_json' => storage_path('app/analytics/service-account-credentials.json'),
    ],
    'search_endpoint' => config('twill.admin_route_name_prefix') . 'search',

    /*
    |--------------------------------------------------------------------------
    | Twill Auth activity related configuration
    |--------------------------------------------------------------------------
    |
     */
    'auth_activity_log' => [
        'login' => false,
        'logout' => false,
    ],
    'auth_activity_causer' => 'users',
];

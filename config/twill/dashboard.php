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
            'routePrefix' => 'exhibitions_events',
            'count' => true,
            'create' => true,
            'search' => true,
            'activity' => true,
            'drafts' => true,
        ],
        'articles' => [
            'name' => 'articles',
            'routePrefix' => 'collection.articles_publications',
            'count' => true,
            'create' => true,
            'search' => true,
            'activity' => true,
            'drafts' => true,
        ],
        'exhibitions' => [
            'name' => 'exhibitions',
            'routePrefix' => 'exhibitions_events',
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
        'selections' => [
            'label' => 'Highlights',
            'label_singular' => 'Highlight',
            'name' => 'selections',
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
        'service_account_credentials_json' => storage_path('app/analytics/service-account-credentials.json'),
    ],
    'search_endpoint' => 'admin.search',
];

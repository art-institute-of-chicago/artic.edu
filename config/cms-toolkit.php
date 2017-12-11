<?php

return [
    'auth_login_redirect_path' => '/featured/homepage',

    'templates_on_frontend_domain' => true,

    'frontend' => [
        'dev_assets_path' => '/dist',
        'views_path' => 'site',
    ],

    'enabled' => [
        'users-in-top-right-nav' => true,
        'buckets' => true
    ],

    'buckets' => [
        'homepage' => [
            'name' => 'Home',
            'buckets' => [
                'home_main_features' => [
                    'name' => 'Home main feature',
                    'bucketables' => [
                        [
                            'module' => 'exhibitions',
                            'name' => 'Exhibitions',
                            'scopes' => ['published' => true],
                        ],
                        [
                            'module' => 'events',
                            'name' => 'Events',
                            'scopes' => ['published' => true],
                        ],
                        [
                            'module' => 'articles',
                            'name' => 'Articles',
                            'scopes' => ['published' => true],
                        ]
                    ],
                    'max_items' => 1,
                ],
                'home_secondary_features' => [
                    'name' => 'Home secondary features',
                    'bucketables' => [
                        [
                            'module' => 'exhibitions',
                            'name' => 'Exhibitions',
                            'scopes' => ['published' => true],
                        ],
                        [
                            'module' => 'events',
                            'name' => 'Events',
                            'scopes' => ['published' => true],
                        ],
                        [
                            'module' => 'articles',
                            'name' => 'Articles',
                            'scopes' => ['published' => true],
                        ],
                        [
                            'module' => 'artworks',
                            'name' => 'Artworks'
                        ]
                    ],
                    'max_items' => 2,
                ],
                'home_art_and_ideas' => [
                    'name' => 'Art and Ideas',
                    'bucketables' => [
                        [
                            'module' => 'articles',
                            'name' => 'Articles',
                            'scopes' => ['published' => true],
                        ],
                        [
                            'module' => 'selections',
                            'name' => 'Selections',
                            'scopes' => ['published' => true],
                        ],
                        [
                            'module' => 'artworks',
                            'name' => 'Artworks'
                        ]
                    ],
                    'max_items' => 6,
                ]
            ]
        ]
    ]
];

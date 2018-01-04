<?php

return [
    'auth_login_redirect_path' => '/featured/homepage',

    'templates_on_frontend_domain' => true,

    'frontend' => [
        'dev_assets_path' => '/dist',
        'views_path' => 'site',
    ],

    'enabled' => [
        'buckets' => true,
        'media-library' => true,
        'file-library' => true,
    ],

    'block_editor' => [
        'blocks' => [
            'text' => [
                'title' => 'Text',
                'icon' => 'text',
                'component' => 'a17-block-text',
            ],
            'quote' => [
                'title' => 'Quote',
                'icon' => 'text',
                'component' => 'a17-block-quote',
            ],
            'image' => [
                'title' => 'Image',
                'icon' => 'image',
                'component' => 'a17-block-image',
            ],
        ],
        'repeaters' => [
            'admissions' => [
                'title' => 'Admission',
                'trigger' => 'Add admission',
                'component' => 'a17-block-admissions',
                'max' => 10,
            ],
            'locations' => [
                'title' => 'Locations',
                'trigger' => 'Add locations',
                'component' => 'a17-block-locations',
                'max' => 10,
            ],
        ],
        'crops' => [
            'image' => [
                'desktop' => [
                    [
                        'name' => 'desktop',
                        'ratio' => 16 / 9,
                    ],
                ],
                'mobile' => [
                    [
                        'name' => 'mobile',
                        'ratio' => 1,
                    ],
                ],
            ],
        ],
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
                        ],
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
                            'name' => 'Artworks',
                        ],
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
                            'name' => 'Artworks',
                        ],
                    ],
                    'max_items' => 6,
                ],
            ],
        ],

        'art_and_ideas' => [
            'name' => 'Art and Ideas',
            'buckets' => [
                'art_and_ideas_main_features' => [
                    'name' => 'Art and Ideas featured articles',
                    'bucketables' => [
                        [
                            'module' => 'articles',
                            'name' => 'Articles',
                            'scopes' => ['published' => true],
                        ],
                    ],
                    'max_items' => 2,
                ],
            ],
        ],
    ],
];

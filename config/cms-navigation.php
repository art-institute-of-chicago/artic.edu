<?php

return [
    'homepage' => [
        'title' => 'Homepage',
        'route' => 'admin.homepage.landing',

        'primary_navigation' => [
            'homepage' => [
                'title' => 'Landing',
                'route' => 'admin.homepage.landing',
            ],
            'home_features' => [
                'title' => 'Features',
                'module' => true,
            ],
        ]
    ],

    'visit' => [
        'title' => 'Visit',
        'route' => 'admin.visit.landing',
        'primary_navigation' => [
            'visit' => [
                'title' => 'Landing',
                'route' => 'admin.visit.landing',
            ],

            'fees' => [
                'title' => 'Admission Fees',
                'route' => 'admin.visit.fees',
            ],
            'feeAges' => [
                'title' => 'Admission Ages',
                'module' => true,
            ],
            'feeCategories' => [
                'title' => 'Admission Categories',
                'module' => true,
            ],

            'hours' => [
                'title' => 'Hours',
                'module' => true,
            ],
            'closures' => [
                'title' => 'Closures',
                'module' => true,
            ],
            'sponsors' => [
                'title' => 'Sponsors',
                'module' => true,
            ],
            'questions' => [
                'title' => 'FAQ',
                'module' => true,
            ],
        ]
    ],

    'exhibitions_events' => [
        'title' => 'Exhibitions & Events',
        'route' => 'admin.exhibitions_events.landing',
        'primary_navigation' => [
            'exhibitions_events' => [
                'title' => 'Landing',
                'route' => 'admin.exhibitions_events.landing',
            ],
            'exhibitions' => [
                'title' => 'Exhibitions',
                'module' => true,
            ],
            'events' => [
                'title' => 'Events',
                'module' => true,
            ],
            'history' => [
                'title' => 'History Landing',
                'route' => 'admin.exhibitions_events.history',
            ],
        ]
    ],

    'collection' => [
        'title' => 'Collection',
        'route' => 'admin.collection.landing',
        'primary_navigation' => [
            'collection' => [
                'title' => 'Landing',
                'route' => 'admin.collection.landing',
            ],
            'artworks' => [
                'title' => 'Artworks',
                'module' => true,
            ],
            'artists' => [
                'title' => 'Artists',
                'module' => true,
            ],
            'articles_publications' => [
                'title' => 'Articles & Publications',
                'route' => 'admin.collection.articles_publications.landing',
                'secondary_navigation' => [
                    'landing' => [
                        'title' => 'Landing',
                        'route' => 'admin.collection.articles_publications.landing',
                    ],
                    'articles' => [
                        'title' => 'Articles',
                        'module' => true,
                    ],
                    'categories' => [
                        'title' => 'Categories',
                        'module' => true,
                    ]
                ],
            ],
        ]
    ]


    // 'featured' => [
    //     'title' => 'Features',
    //     'route' => 'admin.featured.homepage',
    //
    //     'primary_navigation' => [
    //         'homepage' => [
    //             'title' => 'Homepage',
    //             'route' => 'admin.featured.homepage',
    //         ],
    //         'art_and_ideas' => [
    //             'title' => 'Art and Ideas',
    //             'route' => 'admin.featured.art_and_ideas',
    //         ],
    //     ],
    // ],
    // 'landing' => [
    //
    //     'primary_navigation' => [
    //         'art' => [
    //             'title' => 'Art & Ideas',
    //             'route' => 'admin.landing.art',
    //         ],
    //         'visit' => [
    //             'title' => 'Visit',
    //             'route' => 'admin.landing.visit.page',
    //             'secondary_navigation' => [
    //                 'page' => [
    //                     'title' => 'Landing',
    //                     'route' => 'admin.landing.visit.page',
    //                 ],
    //                 'fees' => [
    //                     'title' => 'Admission Fees',
    //                     'route' => 'admin.landing.visit.fees',
    //                 ],
    //                 'feeAges' => [
    //                     'title' => 'Admission Ages',
    //                     'module' => true,
    //                 ],
    //                 'feeCategories' => [
    //                     'title' => 'Admission Categories',
    //                     'module' => true,
    //                 ],
    //             ],
    //         ],
    //         'articles' => [
    //             'title' => 'Articles',
    //             'route' => 'admin.landing.articles',
    //         ],
    //     ],
    // ],
    // 'whatson' => [
    //     'title' => "Content",
    //     'route' => 'admin.whatson.exhibitions.index',
    //
    //     'primary_navigation' => [
    //         'exhibitions' => [
    //             'title' => 'Exhibitions',
    //             'module' => true,
    //         ],
    //         'events' => [
    //             'title' => 'Events',
    //             'module' => true,
    //         ],
    //         'articles' => [
    //             'title' => 'Articles',
    //             'module' => true,
    //         ],
    //         'artists' => [
    //             'title' => 'Artists',
    //             'module' => true,
    //         ],
    //         'artworks' => [
    //             'title' => 'Artworks',
    //             'module' => true,
    //         ],
    //         'selections' => [
    //             'title' => 'Selections',
    //             'module' => true,
    //         ],
    //         'galleries' => [
    //             'title' => 'Galleries',
    //             'module' => true,
    //         ],
    //         'departments' => [
    //             'title' => 'Departments',
    //             'module' => true,
    //         ],
    //     ],
    // ],
    //
    // 'general' => [
    //     'title' => 'General Elements',
    //     'route' => 'admin.general.categories.index',
    //
    //     'primary_navigation' => [
    //         'categories' => [
    //             'title' => 'Article Categories',
    //             'module' => true,
    //         ],
    //         'siteTags' => [
    //             'title' => 'Tags',
    //             'module' => true,
    //         ],
    //         'hours' => [
    //             'title' => 'Hours',
    //             'module' => true,
    //         ],
    //         'closures' => [
    //             'title' => 'Closures',
    //             'module' => true,
    //         ],
    //         'sponsors' => [
    //             'title' => 'Sponsors',
    //             'module' => true,
    //         ],
    //         'questions' => [
    //             'title' => 'FAQ',
    //             'module' => true,
    //         ],
    //         'shopItems' => [
    //             'title' => 'Shop',
    //             'module' => true,
    //         ],
    //         'searchTerms' => [
    //             'title' => 'Search Terms',
    //             'module' => true,
    //         ],
    //     ],
    // ],
];

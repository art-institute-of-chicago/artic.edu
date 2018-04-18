<?php

return [
    'homepage' => [
        'title' => 'Homepage',
        'route' => 'admin.homepage.landing',

        'primary_navigation' => [
            'landing' => [
                'title' => 'Landing',
                'route' => 'admin.homepage.landing',
            ],
            'homeFeatures' => [
                'title' => 'Home Features',
                'module' => true,
            ],

            'collectionFeatures' => [
                'title' => 'Collection Features',
                'module' => true,
            ],
        ]
    ],

    'visit' => [
        'title' => 'Visit',
        'route' => 'admin.visit.landing',
        'primary_navigation' => [
            'landing' => [
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
            'questions' => [
                'title' => 'FAQ',
                'module' => true,
            ],
            'galleries' => [
                'title' => 'Galleries',
                'module' => true,
            ],
            'departments' => [
                'title' => 'Departments',
                'module' => true,
            ],
            'shopItems' => [
                'title' => 'Shop',
                'module' => true,
            ],
        ]
    ],

    'exhibitions_events' => [
        'title' => 'Exhibitions & Events',
        'route' => 'admin.exhibitions_events.landing',
        'primary_navigation' => [
            'landing' => [
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
            'sponsors' => [
                'title' => 'Sponsors',
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
            'landing' => [
                'title' => 'Landing',
                'route' => 'admin.collection.landing',
            ],
            'articles_publications' => [
                'title' => 'Articles & Publications',
                'route' => 'admin.collection.articles_publications.landing',
                'secondary_navigation' => [
                    'landing' => [
                        'title' => 'Landing',
                        'route' => 'admin.collection.articles_publications.landing',
                    ],
                    'articles_landing' => [
                        'title' => 'Articles Landing',
                        'route' => 'admin.collection.articles_publications.articles_landing',
                    ],
                    'articles' => [
                        'title' => 'Articles',
                        'module' => true,
                    ],
                    'categories' => [
                        'title' => 'Categories',
                        'module' => true,
                    ],
                    'videos' => [
                        'title' => 'Videos',
                        'module' => true,
                    ],
                    'printedCatalogs' => [
                        'title' => 'Printed Catalogs',
                        'module' => true,
                    ],
                    'digitalCatalogs' => [
                        'title' => 'Digital Catalogs',
                        'module' => true,
                    ],
                    // 'scholarlyJournals' => [
                    //     'title' => 'Scholarly Journals',
                    //     'module' => true,
                    // ]
                ],
            ],
            'research_resources' => [
                'title' => 'Research and Resources',
                'route' => 'admin.collection.research_resources.landing',
                'secondary_navigation' => [
                    'landing' => [
                        'title' => 'Landing',
                        'route' => 'admin.collection.research_resources.landing',
                    ],
                    'researchGuides' => [
                        'title' => 'Research Guides',
                        'module' => true,
                    ],
                    'educatorResources' => [
                        'title' => 'Educator Resources',
                        'module' => true,
                    ]
                ],
            ],
            'artists' => [
                'title' => 'Artists',
                'module' => true,
            ],
            'artworks' => [
                'title' => 'Artworks',
                'module' => true,
            ],
            'selections' => [
                'title' => 'Selections',
                'module' => true,
            ],
        ]
    ],

    // 'featured' => [
    //     'title' => 'Features',
    //     'route' => 'admin.featured.art_and_ideas',

    //     'primary_navigation' => [
    //         'art_and_ideas' => [
    //             'title' => 'Art and Ideas',
    //             'route' => 'admin.featured.art_and_ideas',
    //         ],
    //     ],
    // ],


    'generic' => [
        'title' => 'Pages',
        'route' => 'admin.generic.genericPages.index',

        'primary_navigation' => [
            'genericPages' => [
                'title' => 'Generic Pages',
                'module' => true,
            ],
            'pressReleases' => [
                'title' => 'Press Releases',
                'module' => true,
            ]
        ],
    ],

    'general' => [
        'title' => 'General Elements',
        'route' => 'admin.general.siteTags.index',

        'primary_navigation' => [
            'siteTags' => [
                'title' => 'Tags',
                'module' => true,
            ],
            'searchTerms' => [
                'title' => 'Search Terms',
                'module' => true,
            ],
            'pageCategories' => [
                'title' => 'Page Categories',
                'module' => true,
            ],
            'catalogCategories' => [
                'title' => 'Catalog Categories',
                'module' => true,
            ],
            'resourceCategories' => [
                'title' => 'Resource Categories',
                'module' => true,
            ],
        ],
    ],

];

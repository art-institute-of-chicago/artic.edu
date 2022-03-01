<?php

$nav = [
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

            'lightboxes' => [
                'title' => 'Lightboxes',
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
            'buildingClosures' => [
                'title' => 'Closures',
                'module' => true,
            ],
            'questions' => [
                'title' => 'FAQ',
                'module' => true,
            ],
            'virtualTours' => [
                'title' => 'Virtual Tours',
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
            'emailSeries' => [
                'title' => 'Email Series',
                'module' => true
            ],
            'magazineIssues' => [
                'title' => 'Magazine Issues',
                'module' => true
            ],
            'miradors' => [
                'title' => 'Mirador',
                'module' => true
            ]
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
            'categoryTerms' => [
                'title' => 'Quick Filters',
                'module' => true,
            ],
            'articles_publications' => [
                'title' => 'Writings',
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
                    'printedPublications' => [
                        'title' => 'Print Publications',
                        'module' => true,
                    ],
                    'digitalPublications' => [
                        'title' => 'Digital Publications',
                        'module' => true,
                    ],
                ],
            ],
            'research_resources' => [
                'title' => 'Resources',
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
            'highlights' => [
                'title' => 'Highlights',
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
            'interactive_features' => [
                'title' => 'Interactive Features',
                'route' => 'admin.collection.interactive_features.experiences.index',
                'secondary_navigation' => [
                    'experiences' => [
                        'title' => 'Experiences',
                        'module' => true,
                    ],
                    'interactiveFeatures' => [
                        'title' => 'Groupings',
                        'module' => true,
                    ],
                ],
            ],
            'authors' => [
                'title' => 'Authors',
                'module' => true,
            ],
            'issues' => [
                'title' => 'Issues',
                'module' => true,
            ]
        ]
    ],
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
            ],
            'exhibitionPressRooms' => [
                'title' => 'Exhibition Press Rooms',
                'module' => true,
            ],
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
            'shopItems' => [
                'title' => 'Shop',
                'module' => true,
            ],
            'eventPrograms' => [
                'title' => 'Event Programs',
                'module' => true,
            ],
            'vanityRedirects' => [
                'title' => 'Vanity Redirects',
                'module' => true
            ]
        ],
    ],

];

return $nav;

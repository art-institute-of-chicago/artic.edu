<?php

$nav = [
    'homepage' => [
        'title' => 'Homepage',
        'route' => 'twill.homepage.landing',

        'primary_navigation' => [
            'landing' => [
                'title' => 'Landing',
                'route' => 'twill.homepage.landing',
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
        'route' => 'twill.visit.landing',
        'primary_navigation' => [
            'landing' => [
                'title' => 'Landing',
                'route' => 'twill.visit.landing',
            ],
            'fees' => [
                'title' => 'Admission Fees',
                'route' => 'twill.visit.fees',
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
            'myMuseumTourItems' => [
                'title' => 'My Museum Tour',
                'module' => true,
            ],
        ]
    ],

    'exhibitionsEvents' => [
        'title' => 'Exhibitions & Events',
        'route' => 'twill.exhibitionsEvents.landing',
        'primary_navigation' => [
            'landing' => [
                'title' => 'Landing',
                'route' => 'twill.exhibitionsEvents.landing',
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
                'route' => 'twill.exhibitionsEvents.history',
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
        'route' => 'twill.collection.landing',
        'primary_navigation' => [
            'landing' => [
                'title' => 'Landing',
                'route' => 'twill.collection.landing',
            ],
            'categoryTerms' => [
                'title' => 'Quick Filters',
                'module' => true,
            ],
            'articles_publications' => [
                'title' => 'Writings',
                'route' => 'twill.collection.articles_publications.landing',
                'secondary_navigation' => [
                    'landing' => [
                        'title' => 'Landing',
                        'route' => 'twill.collection.articles_publications.landing',
                    ],
                    'articles_landing' => [
                        'title' => 'Articles Landing',
                        'route' => 'twill.collection.articles_publications.articles_landing',
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
                'route' => 'twill.collection.research_resources.landing',
                'secondary_navigation' => [
                    'landing' => [
                        'title' => 'Landing',
                        'route' => 'twill.collection.research_resources.landing',
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
            'interactiveFeatures' => [
                'title' => 'Interactive Features',
                'route' => 'twill.collection.interactiveFeatures.experiences.index',
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
        ]
    ],
    'generic' => [
        'title' => 'Pages',
        'route' => 'twill.generic.genericPages.index',

        'primary_navigation' => [
            'landingPages' => [
                'title' => 'Landing Pages',
                'module' => true,
            ],
            'genericPages' => [
                'title' => 'Generic Pages',
                'module' => true,
            ],
            'pageFeatures' => [
                'title' => 'Page Features',
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
        'route' => 'twill.general.siteTags.index',

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

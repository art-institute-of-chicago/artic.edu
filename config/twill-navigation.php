<?php

$nav = [
    'visit' => [
        'title' => 'Visit',
        'route' => 'twill.visit.hours.index',
        'primary_navigation' => [
            'hours' => [
                'title' => 'Hours',
                'module' => true,
            ],
            'fees' => [
                'title' => 'Admission Fees',
                'module' => true,
            ],
            'feeAges' => [
                'title' => 'Admission Ages',
                'module' => true,
            ],
            'feeCategories' => [
                'title' => 'Admission Categories',
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
            'history' => [
                'title' => 'History Landing',
                'route' => 'twill.exhibitionsEvents.history',
            ],
            'sponsors' => [
                'title' => 'Sponsors',
                'module' => true,
            ],
            'emailSeries' => [
                'title' => 'Email Series',
                'module' => true
            ],
            'eventPrograms' => [
                'title' => 'Event Programs',
                'module' => true,
            ],
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
            'artists' => [
                'title' => 'Artists',
                'module' => true,
            ],
            'artworks' => [
                'title' => 'Artworks',
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
            'educatorResources' => [
                'title' => 'Educator Resources',
                'module' => true,
            ],
            'resourceCategories' => [
                'title' => 'Resource Categories',
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
            'digitalExplorers' => [
              'title' => 'Digital Explorers',
              'module' => true,
            ],
            'miradors' => [
                'title' => 'Mirador',
                'module' => true
            ]
        ]
    ],
    'content' => [
        'title' => 'Content',
        'route' => 'twill.collection.authors.index',

        'primary_navigation' => [
            'authors' => [
                'title' => 'Authors',
                'module' => true,
            ],
            'editorial' => [
                'title' => 'Editorial',
                'route' => 'twill.collection.articlesPublications.articles.index',
                'secondary_navigation' => [
                    'articles' => [
                        'title' => 'Articles',
                        'module' => true,
                    ],
                    'categories' => [
                        'title' => 'Article Categories',
                        'module' => true,
                    ],
                    'highlights' => [
                        'title' => 'Highlights',
                        'module' => true,
                    ],
                    'magazineIssues' => [
                        'title' => 'Magazine Issues',
                        'module' => true
                    ],
                ],
            ],
            'video' => [
                'title' => 'Video',
                'route' => 'twill.collection.articlesPublications.videos.index',
                'secondary_navigation' => [
                    'videos' => [
                        'title' => 'Videos',
                        'module' => true,
                    ],
                    'videoCategories' => [
                        'title' => 'Video Categories',
                        'module' => true,
                    ],
                    'playlists' => [
                        'title' => 'Playlists',
                        'module' => true,
                    ],
                ],
            ],
            'publications' => [
                'title' => 'Publications',
                'route' => 'twill.collection.articlesPublications.printedPublications.index',
                'secondary_navigation' => [
                    'printedPublications' => [
                        'title' => 'Print Publications',
                        'module' => true,
                    ],
                    'digitalPublications' => [
                        'title' => 'Digital Publications',
                        'module' => true,
                    ],
                    'catalogCategories' => [
                        'title' => 'Catalog Categories',
                        'module' => true,
                    ],
                ],
            ],
        ]
    ],
    'pages' => [
        'title' => 'Pages',
        'route' => 'twill.generic.landingPages.index',

        'primary_navigation' => [
            'landingPages' => [
                'title' => 'Landing Pages',
                'module' => true,
            ],
            'genericPages' => [
                'title' => 'Generic Pages',
                'module' => true,
            ],
            'lightboxes' => [
                'title' => 'Lightboxes',
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
        'title' => 'Site Settings',
        'route' => 'twill.general.searchTerms.index',

        'primary_navigation' => [
            'searchTerms' => [
                'title' => 'Search Terms',
                'module' => true,
            ],
            'vanityRedirects' => [
                'title' => 'Vanity Redirects',
                'module' => true
            ],
            'integrations' => [
                'title' => 'Integrations',
                'route' => 'twill.general.integrations.show',
            ],
            'illuminatedLinks' => [
                'title' => 'Illuminated Links',
                'module' => true,
            ],
        ],
    ],
];

return $nav;

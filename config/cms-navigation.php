<?php

return [
    'featured' => [
        'title' => 'Features',
        'route' => 'admin.featured.homepage',

        'primary_navigation' => [
            'homepage' => [
                'title' => 'Homepage',
                'route' => 'admin.featured.homepage',
            ],
            'art_and_ideas' => [
                'title' => 'Art and Ideas',
                'route' => 'admin.featured.art_and_ideas'
            ]
        ]
    ],
    'landing' => [
        'title' => "Pages",
        'route' => 'admin.landing.home',

        'primary_navigation' => [
            'home' => [
                'title' => 'Homepage',
                'route' => 'admin.landing.home',
            ],
            'exhibitions' => [
                'title' => 'Exhibitions',
                'route' => 'admin.landing.exhibitions',
            ],
            'art' => [
                'title' => 'Art & Ideas',
                'route' => 'admin.landing.art',
            ],
            'visit' => [
                'title' => 'Visit',
                'route' => 'admin.landing.visit.page',

                'secondary_navigation' => [
                    'page' => [
                        'title' => 'Visit Landing',
                        'route' => 'admin.landing.visit.page',
                    ],
                    'questions' => [
                        'title' => 'FAQ',
                        'module' => true,
                    ],
                    'fees' => [
                        'title' => 'Admission Fees',
                        'route' => 'admin.landing.visit.fees',
                    ],
                    'feeAges' => [
                        'title' => 'Admission Ages',
                        'module' => true,
                    ],
                    'feeCategories' => [
                        'title' => 'Admission Categories',
                        'module' => true,
                    ]
                ]
            ]
        ]
    ],
    'whatson' => [
        'title' => "Content",
        'route' => 'admin.whatson.exhibitions.index',

        'primary_navigation' => [
          'exhibitions' => [
            'title' => 'Exhibitions',
            'module' => true,
          ],
          'events' => [
            'title' => 'Events',
            'module' => true,
          ],
          'articles' => [
            'title' => 'Articles',
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
          'selections' => [
            'title' => 'Selections',
            'module' => true,
          ]
        ]
    ],

    'general' => [
      'title' => 'General Elements',
      'route' => 'admin.general.categories.index',

      'primary_navigation' => [
        'categories' => [
          'title' => 'Categories',
          'module' => true,
        ],
        'siteTags' => [
          'title' => 'Tags',
          'module' => true,
        ],
        'segments' => [
          'title' => 'Segments',
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
      ]
    ]
];

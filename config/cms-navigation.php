<?php

return [
    'featured' => [
        'title' => 'Features',
        'route' => 'admin.featured.homepage',

        'primary_navigation' => [
            'homepage' => [
                'title' => 'Homepage',
                'route' => 'admin.featured.homepage',
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
      ]
    ]
];

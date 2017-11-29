<?php

return [
    'home' => [
        'title' => 'Homepage',
        'route' => 'admin.home',
    ],
    'landing' => [
        'title' => "Landing Pages",
        'route' => 'admin.landing.exhibitions',

        'primary_navigation' => [
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
        'title' => "What's on",
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

    // 'users' => [
    //     'can' => 'edit',
    //     'title' => 'Users',
    //     'module' => true,
    //     'route' => 'index',
    // ],

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
        ]
      ]
    ]
];

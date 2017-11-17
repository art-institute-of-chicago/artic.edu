<?php

return [
    'exhibitions' => [
        'title' => 'Exhibitions',
        'route' => 'admin.exhibitions.exhibitions.index',

        'primary_navigation' => [
          'exhibitions' => [
            'title' => 'Exhibitions',
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

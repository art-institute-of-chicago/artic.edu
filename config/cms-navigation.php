<?php

return [
    'home' => [
        'title' => 'Home',
        'route' => 'admin.users.index',
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
        'categorySegments' => [
          'title' => 'Category Segments',
          'module' => true,
        ]
      ]
    ]
];

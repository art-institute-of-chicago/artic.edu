<?php

return [
    'home' => [
        'title' => 'Home',
        'route' => 'admin.users.index',
    ],

    'users' => [
        'can' => 'edit',
        'title' => 'Users',
        'module' => true,
        'route' => 'index',
    ],
];

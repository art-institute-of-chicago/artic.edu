<?php

return [
    'path' => app_path('Twill/Capsules'),

    'namespaces' => [
        'subdir' => '',

        'base' => 'App\Twill\Capsules',

        'models' => 'Models',

        'repositories' => 'Repositories',

        'controllers' => 'Http\Controllers',

        'requests' => 'Http\Requests',
    ],

    'list' => [
        // ['name' => 'Artists', 'enabled' => true],
        // ['name' => 'Posts', 'enabled' => true],
    ],

    'capsule_config_prefix' => 'twill.capsule',
    'capsule_repository_prefix' => env('CAPSULE_REPOSITORY_PREFIX', 'area17')
];

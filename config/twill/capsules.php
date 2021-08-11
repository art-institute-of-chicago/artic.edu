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
    ],

    'capsule_config_prefix' => 'twill.capsule'
];

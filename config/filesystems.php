<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
     */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
     */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID', env('S3_KEY')),
            'secret' => env('AWS_SECRET_ACCESS_KEY', env('S3_SECRET')),
            'region' => env('AWS_DEFAULT_REGION', env('S3_REGION', 'us-east-1')),
            'bucket' => env('AWS_BUCKET', env('S3_BUCKET')),
            'url' => env('AWS_URL', env('S3_URL')),
            'endpoint' => env('AWS_ENDPOINT', env('S3_ENDPOINT')),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

        'iiif_s3' => [
            'driver' => 's3',
            'key' => env('IIIF_S3_KEY', env('S3_KEY')),
            'secret' => env('IIIF_S3_SECRET', env('S3_SECRET')),
            'region' => env('IIIF_S3_REGION'),
            'bucket' => env('IIIF_S3_BUCKET'),
            'url' => env('IIIF_S3_URL'),
            'endpoint' => env('IIIF_S3_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

        'pdf_s3' => [
            'driver' => 's3',
            'key' => env('PDF_S3_KEY', env('S3_KEY')),
            'secret' => env('PDF_S3_SECRET', env('S3_SECRET')),
            'region' => env('PDF_S3_REGION'),
            'bucket' => env('PDF_S3_BUCKET'),
            'url' => env('PDF_S3_URL'),
            'endpoint' => env('PDF_S3_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],

        'osci_s3' => [
            'driver' => 's3',
            'key' => env('S3_KEY'),
            'secret' => env('S3_SECRET'),
            'region' => env('OSCI_S3_REGION', env('S3_REGION')),
            'bucket' => env('OSCI_S3_BUCKET'),
            'endpoint' => env('OSCI_S3_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */
    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];

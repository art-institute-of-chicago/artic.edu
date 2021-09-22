<?php

return [
    'base_url' => env('DAMS_BASE_URL', 'https://lakeimagesweb.artic.edu/iiif/'),

    'cdn_enabled' => (bool) env('CDN_DAMS_ENABLED', false),
    'base_url_cdn' => env('CDN_DAMS_BASE_URL', env('DAMS_BASE_URL', 'https://lakeimagesweb.artic.edu/iiif/')),

    'version' => '2',
];

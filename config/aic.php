<?php

return [

    'is_preview_mode' => false,
    'show_design_grids' => env('SHOW_DESIGN_GRIDS', false),
    'hide_interactive_features' => env('HIDE_INTERACTIVE_FEATURES', true),
    'prince_command' => env('PRINCE_COMMAND', '/usr/bin/prince'),
    'protocol' => env('APP_PROTOCOL', 'https'),
    'iiif_s3_endpoint' => env('IIIF_S3_ENDPOINT'),
    'sales_site_url' => env('SALES_SITE_URL', 'https://sales.artic.edu'),

];

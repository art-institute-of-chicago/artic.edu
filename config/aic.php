<?php

return [

    'is_preview_mode' => env('ALWAYS_PREVIEW_MODE', false),
    'show_design_grids' => env('SHOW_DESIGN_GRIDS', false),
    'hide_interactive_features' => env('HIDE_INTERACTIVE_FEATURES', true),
    'use_most_similar_for_artwork_sidebar' => env('USE_MOST_SIMILAR_FOR_ARTWORK_SIDEBAR', false),
    'prince_command' => env('PRINCE_COMMAND', '/usr/bin/prince'),
    'protocol' => env('APP_PROTOCOL', 'https'),
    'iiif_s3_endpoint' => env('IIIF_S3_ENDPOINT'),
    'pdf_s3_endpoint' => env('PDF_S3_ENDPOINT'),
    'pdf_debug' => env('PDF_DEBUG', false),
    'sales_site_url' => env('SALES_SITE_URL', 'https://sales.artic.edu'),
    'vtour_bucket' => env('AWS_VTOUR_BUCKET'),

];

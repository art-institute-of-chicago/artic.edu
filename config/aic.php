<?php

return [
    'prince_command' => env('PRINCE_COMMAND', '/usr/bin/prince'),
    'protocol' => env('APP_PROTOCOL', 'https'),
    'iiif_s3_endpoint' => env('IIIF_S3_ENDPOINT'),
    'sales_site_url' => env('SALES_SITE_URL', 'https://sales.artic.edu'),
    'vtour_bucket' => env('AWS_VTOUR_BUCKET'),

    'pdf_s3_enabled' => env('PDF_S3_ENABLED', false),
    'pdf_s3_endpoint' => env('PDF_S3_ENDPOINT'),
    'pdf_debug' => env('PDF_DEBUG', false),

    // Feature flags
    'is_preview_mode' => env('ALWAYS_PREVIEW_MODE', false),
    'show_design_grids' => env('SHOW_DESIGN_GRIDS', false),
    'use_most_similar_for_artwork_sidebar' => env('USE_MOST_SIMILAR_FOR_ARTWORK_SIDEBAR', false),
    'cache_revassets' => env('CACHE_REVASSETS', false),
    'show_artwork_color_tag' => env('SHOW_ARTWORK_COLOR_TAG', false),
    'show_event_series_emails' => env('SHOW_EVENT_SERIES_EMAILS', false),
    'show_button_and_date_select_lightbox_variation' => env('SHOW_BUTTON_AND_DATE_SELECT_LIGHTBOX_VARIATION', false),
    'show_artist_gender' => env('SHOW_ARTIST_GENDER', false),
    'show_artist_places' => env('SHOW_ARTIST_PLACES', false),
];

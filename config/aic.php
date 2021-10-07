<?php

return [
    'prince_command' => env('PRINCE_COMMAND', '/usr/bin/prince'),
    'protocol' => env('APP_PROTOCOL', 'https'),
    'iiif_s3_endpoint' => env('IIIF_S3_ENDPOINT'),
    'sales_site_url' => env('SALES_SITE_URL', 'https://sales.artic.edu'),
    'vtour_bucket' => env('AWS_VTOUR_BUCKET'),

    'pdf_on_save' => (bool) env('PDF_ON_SAVE', true),
    'pdf_s3_enabled' => (bool) env('PDF_S3_ENABLED', false),
    'pdf_s3_endpoint' => env('PDF_S3_ENDPOINT'),
    'pdf_debug' => (bool) env('PDF_DEBUG', false),

    // Feature flags
    'is_preview_mode' => (bool) env('ALWAYS_PREVIEW_MODE', false),
    'show_design_grids' => (bool) env('SHOW_DESIGN_GRIDS', false),
    'use_most_similar_for_artwork_sidebar' => (bool) env('USE_MOST_SIMILAR_FOR_ARTWORK_SIDEBAR', false),
    'use_compiled_revassets' => (bool) env('USE_COMPILED_REVASSETS', false),
    'show_artwork_color_tag' => (bool) env('SHOW_ARTWORK_COLOR_TAG', false),
    'show_event_series_emails' => (bool) env('SHOW_EVENT_SERIES_EMAILS', false),
    'show_button_and_date_select_lightbox_variation' => (bool) env('SHOW_BUTTON_AND_DATE_SELECT_LIGHTBOX_VARIATION', false),
    'show_artist_gender' => (bool) env('SHOW_ARTIST_GENDER', false),
    'show_artist_places' => (bool) env('SHOW_ARTIST_PLACES', false),
];

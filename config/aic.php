<?php

return [
    'prince_command' => env('PRINCE_COMMAND', '/usr/bin/prince'),
    'protocol' => env('APP_PROTOCOL', 'https'),
    'iiif_s3_endpoint' => env('IIIF_S3_ENDPOINT'),
    'sales_site_url' => env('SALES_SITE_URL', 'https://sales.artic.edu'),
    'vtour_bucket' => env('AWS_VTOUR_BUCKET'),
    'http_username' => env('HTTP_USERNAME'),
    'http_password' => env('HTTP_PASSWORD'),
    'exhibition_update_recipients' => env('EXHIBITION_UPDATE_RECIPIENTS'),

    // ART-48: For "Research Center"; see Departments filter
    'department_archive_title' => env('DEPARTMENT_ARCHIVE_TITLE', 'AIC Archives'),
    'department_library_title' => env('DEPARTMENT_LIBRARY_TITLE', 'Ryerson and Burnham Libraries Special Collections'),

    'pdf_on_save' => (bool) env('PDF_ON_SAVE', true),
    'pdf_s3_enabled' => (bool) env('PDF_S3_ENABLED', false),
    'pdf_s3_endpoint' => env('PDF_S3_ENDPOINT'),
    'pdf_debug' => (bool) env('PDF_DEBUG', false),

    'osci_s3_bucket' => env('OSCI_S3_BUCKET'),
    'osci_s3_endpoint' => env('OSCI_S3_ENDPOINT'),
    'osci_s3_regiont' => env('OSCI_S3_REGION'),

    'disable_extra_scripts' => (bool) env('DISABLE_EXTRA_SCRIPTS', false),

    'hide_objects_from_tours' => env('HIDE_OBJECTS_FROM_TOURS'),
    'hide_galleries_from_tours' => env('HIDE_GALLERIES_FROM_TOURS'),

    // Feature flags
    'is_preview_mode' => (bool) env('ALWAYS_PREVIEW_MODE', false),
    'show_design_grids' => (bool) env('SHOW_DESIGN_GRIDS', false),
    'use_most_similar_for_artwork_sidebar' => (bool) env('USE_MOST_SIMILAR_FOR_ARTWORK_SIDEBAR', false),
    'use_compiled_revassets' => (bool) env('USE_COMPILED_REVASSETS', false),
    'show_artwork_color_tag' => (bool) env('SHOW_ARTWORK_COLOR_TAG', false),
    'show_event_series_emails' => (bool) env('SHOW_EVENT_SERIES_EMAILS', false),
    'show_button_and_date_select_lightbox_variation' => (bool) env('SHOW_BUTTON_AND_DATE_SELECT_LIGHTBOX_VARIATION', false),
    'show_artist_gender' => (bool) env('SHOW_ARTIST_GENDER', false),
    'show_hours_in_footer' => (bool) env('SHOW_HOURS_IN_FOOTER', false),
    'disable_captcha' => (bool) env('DISABLE_CAPTCHA', false),
    'show_default_related_items' => (bool) env('SHOW_DEFAULT_RELATED_ITEMS', true),

    // Branding
    'branding' => [
        'digital_publications' => [
            'colors' => [
                '#282829',
                '#422E22',
                '#284725',
                '#1E3F49',
                '#1C2454',
                '#35295A',
                '#711F2A',
                '#983820',
                '#E19E26',
                '#9D9FA2',
                '#A39282',
                '#A1B981',
                '#75B4BA',
                '#77A8D5',
                '#8C8FBE',
                '#D58FA2',
                '#EC9E6C',
                '#F8EB83',
            ],
        ]
    ],
];

<?php

return [
    'prince_command' => env('PRINCE_COMMAND', '/usr/bin/prince'),
    'protocol' => env('APP_PROTOCOL', 'https'),
    'iiif_s3_endpoint' => env('IIIF_S3_ENDPOINT'),
    'sales_site_url' => env('SALES_SITE_URL', 'https://sales.artic.edu'),
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

    'trust_hosts' => env('TRUST_HOSTS') ? explode(',', env('TRUST_HOSTS')) : [],

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
        'colors' => [
            'general' => [
                '#1E3F49',
                '#282829',
            ],
            'digital_publications' => [
                '#1E2753' => 'Darkest Blue',
                '#1E3D47' => 'Darkest Teal',
                '#282829' => 'Darkest Gray',
                '#2D3E23' => 'Darkest Green',
                '#3A254F' => 'Darkest Purple',
                '#3F2D22' => 'Darkest Brown',
                '#620C17' => 'Darkest Red',
                '#8E351F' => 'Darkest Orange',
                '#91C8CD' => 'Light Teal',
                '#A0B8E8' => 'Light Blue',
                '#ADC47C' => 'Light Green',
                '#AE96D0' => 'Light Purple',
                '#C3AEA1' => 'Light Brown',
                '#C6C3C5' => 'Light Gray',
                '#CE8D19' => 'Darkest Yellow',
                '#DF98AC' => 'Light Red',
                '#FFA66E' => 'Light Orange',
                '#FFF181' => 'Light Yellow',
            ],
            'research_center' => [
                '#CED8EE',
            ],
        ]
    ],
];

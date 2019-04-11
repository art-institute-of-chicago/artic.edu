<?php

return [
    'users_table' => 'users',
    'password_resets_table' => 'password_resets',
    'bind_exception_handler' => false,

    'auth_login_redirect_path' => '/homepage/landing',

    'templates_on_frontend_domain' => true,

    'frontend' => [
        'dev_assets_path' => '/dist',
    ],

    'enabled' => [
        'buckets' => true,
        'media-library' => true,
        'file-library' => true,
        'dashboard' => false,
        'search' => true,
    ],

    'block_editor' => [
        'block_single_layout' => 'layouts.block',
        'block_preview_render_childs' => false,
        'block_presenter_path' => App\Presenters\Admin\BlockPresenter::class,
        'blocks' => [
            'paragraph' => [
                'title' => 'Paragraph',
                'icon' => 'text',
                'component' => 'a17-block-paragraph',
            ],
            'image' => [
                'title' => 'Image',
                'icon' => 'image',
                'component' => 'a17-block-image',
            ],
            'artwork' => [
                'title' => 'Artwork',
                'icon' => 'image',
                'component' => 'a17-block-artwork',
            ],
            'split_block' => [
                'title' => 'Split block',
                'icon' => 'text',
                'component' => 'a17-block-split_block',
            ],
            'gallery' => [
                'title' => 'Gallery',
                'icon' => 'image',
                'component' => 'a17-block-gallery',
            ],
            'artworks' => [
                'title' => 'Artworks gallery',
                'icon' => 'image',
                'component' => 'a17-block-artworks',
            ],
            'child_pages' => [
                'title' => 'Child pages link block',
                'icon' => 'image',
                'component' => 'a17-block-child_pages',
            ],
            'link' => [
                'title' => 'Link',
                'icon' => 'text',
                'component' => 'a17-block-link',
            ],
            'accordion' => [
                'title' => 'Accordion',
                'icon' => 'text',
                'component' => 'a17-block-accordion',
            ],
            'list' => [
                'title' => 'List',
                'icon' => 'text',
                'component' => 'a17-block-list',
            ],
            'timeline' => [
                'title' => 'Timeline',
                'icon' => 'text',
                'component' => 'a17-block-timeline',
            ],
            'video' => [
                'title' => 'Video',
                'icon' => 'image',
                'component' => 'a17-block-video',
            ],
            'tour_stop' => [
                'title' => 'Audio Tour Stop',
                'icon' => 'image',
                'component' => 'a17-block-tour_stop',
            ],
            'media_embed' => [
                'title' => 'Media embed',
                'icon' => 'text',
                'component' => 'a17-block-media_embed',
            ],
            'quote' => [
                'title' => 'Quote',
                'icon' => 'text',
                'component' => 'a17-block-quote',
            ],
            'hr' => [
                'title' => 'Horizontal rule',
                'icon' => 'text',
                'component' => 'a17-block-hr',
            ],
            'button' => [
                'title' => 'Button',
                'icon' => 'text',
                'component' => 'a17-block-button',
            ],
            'membership_banner' => [
                'title' => 'Banner',
                'icon' => 'text',
                'component' => 'a17-block-membership_banner',
            ],
            'mobile_app' => [
                'title' => 'Mobile app promo',
                'icon' => 'text',
                'component' => 'a17-block-mobile_app',
            ],
            'shop_items' => [
                'title' => 'Featured products',
                'icon' => 'image',
                'component' => 'a17-block-shop_items',
            ],
            'event' => [
                'title' => 'Event',
                'icon' => 'text',
                'component' => 'a17-block-event',
            ],
            'newsletter_signup_inline' => [
                'title' => 'Newsletter signup inline',
                'icon' => 'text',
                'component' => 'a17-block-newsletter_signup_inline',
            ],
            'newsletter_signup_footer' => [
                'title' => 'Newsletter signup footer',
                'icon' => 'text',
                'component' => 'a17-block-newsletter_signup_footer',
            ],
            'citation' => [
                'title' => 'Citation',
                'icon' => 'text',
                'component' => 'a17-block-citation',
            ],
            'search_bar' => [
                'title' => 'External search bar',
                'icon' => 'text',
                'component' => 'a17-block-search_bar',
            ],
            'references' => [
                'title' => 'References',
                'icon' => 'text',
                'component' => 'a17-block-references',
            ],
            'plan_your_visit' => [
                'title' => 'Plan Your Visit',
                'icon' => 'text',
                'component' => 'a17-block-plan_your_visit',
            ],
            'footnote' => [
                'title' => 'Footnote',
                'icon' => 'text',
                'component' => 'a17-block-footnote',
            ],
            'digital_label' => [
                'title' => 'Interactive feature',
                'icon' => 'image',
                'component' => 'a17-block-digital_label',
            ],
        ],
        'repeaters' => [
            'admissions' => [
                'title' => 'Admission',
                'trigger' => 'Add admission',
                'component' => 'a17-block-admissions',
                'max' => 10,
            ],
            'locations' => [
                'title' => 'Museum Address',
                'trigger' => 'Add Museum Address',
                'component' => 'a17-block-locations',
                'max' => 10,
            ],
            'featured_hours' => [
                'title' => 'Museum Hours',
                'trigger' => 'Add hours',
                'component' => 'a17-block-featured_hours',
                'max' => 3,
            ],
            'dining_hours' => [
                'title' => 'Dining',
                'trigger' => 'Add dining hours',
                'component' => 'a17-block-dining_hours',
                'max' => 3,
            ],
            'faqs' => [
                'title' => 'FAQ',
                'trigger' => 'Add FAQ',
                'component' => 'a17-block-faqs',
                'max' => 5,
            ],
            'families' => [
                'title' => 'Families, teens and educators',
                'trigger' => 'Add item',
                'component' => 'a17-block-families',
                'max' => 3,
            ],
            'accordion_item' => [
                'title' => 'Accordion Item',
                'trigger' => 'Add accordion item',
                'component' => 'a17-block-accordion_item',
                'max' => 20,
            ],
            'list_item' => [
                'title' => 'List Item',
                'trigger' => 'Add item',
                'component' => 'a17-block-list_item',
                'max' => 10,
            ],
            'gallery_item' => [
                'title' => 'Gallery Item',
                'trigger' => 'Add Image',
                'component' => 'a17-block-gallery_item',
                'max' => 10,
            ],
            'dateRules' => [
                'title' => 'Date Rule',
                'trigger' => 'Add Date Rule',
                'component' => 'a17-block-date_rule',
                'max' => 10,
            ],
            'offer' => [
                'title' => 'Offer',
                'trigger' => 'Add offer',
                'component' => 'a17-block-offer',
                'max' => 10,
            ],
            'offers' => [
                'title' => 'Offers',
                'trigger' => 'Add offer',
                'component' => 'a17-block-offers',
                'max' => 10,
            ],
            'timeline_item' => [
                'title' => 'Timeline Item',
                'trigger' => 'Add Timeline',
                'component' => 'a17-block-timeline_item',
                'max' => 10,
            ],
            'experience_image' => [
                'title' => 'Experience image',
                'trigger' => 'Add Experience Image',
                'component' => 'a17-block-experience_image',
                'max' => 1,
            ],
            'tooltip_experience_image' => [
                'title' => 'Experience image',
                'trigger' => 'Add Experience Image',
                'component' => 'a17-block-experience_image',
                'max' => 1,
            ],
            'attract_experience_image' => [
                'title' => 'Experience image',
                'trigger' => 'Add Experience Image',
                'component' => 'a17-block-experience_image',
                'max' => 3,
            ],
            'end_experience_image' => [
                'title' => 'Experience image',
                'trigger' => 'Add Experience Image',
                'component' => 'a17-block-experience_image',
                'max' => 3,
            ],
            'end_bg_experience_image' => [
                'title' => 'Background image',
                'trigger' => 'Add Background Image',
                'component' => 'a17-block-experience_image',
                'max' => 1,
            ],
            'slide_primary_experience_image' => [
                'title' => 'Primary experience image',
                'trigger' => 'Add Primary Experience Image',
                'component' => 'a17-block-experience_image',
                'max' => 1,
            ],
            'slide_secondary_experience_image' => [
                'title' => 'Experience image',
                'trigger' => 'Add Secondary Experience Image',
                'component' => 'a17-block-experience_image',
                'max' => 1,
            ],
            'compare_experience_image_1' => [
                'title' => 'Compare experience image 1',
                'trigger' => 'Add Compare Experience Image 1',
                'component' => 'a17-block-experience_image',
                'max' => 1,
            ],
            'compare_experience_image_2' => [
                'title' => 'Compare experience image 2',
                'trigger' => 'Add Compare Experience Image 2',
                'component' => 'a17-block-experience_image',
                'max' => 1,
            ],
            'compare_experience_modal' => [
                'title' => 'Compare experience modal',
                'trigger' => 'Add Compare Experience Modal',
                'component' => 'a17-block-experience_image',
                'max' => 2,
            ],
            'experience_modal' => [
                'title' => 'Experience Modal',
                'trigger' => 'Add Experience Modal',
                'component' => 'a17-block-experience_modal',
                'max' => 1,
            ],
            'primary_experience_modal' => [
                'title' => 'Primay Experience Modal',
                'trigger' => 'Add Primary Experience Modal',
                'component' => 'a17-block-experience_modal',
                'max' => 1,
            ],
            'secondary_experience_modal' => [
                'title' => 'Secondary Experience Modal',
                'trigger' => 'Add Secondary Experience Modal',
                'component' => 'a17-block-experience_modal',
                'max' => 1,
            ],
        ],
        'crops' => [
            'image' => [
                'desktop' => [
                    [
                        'name' => 'desktop',
                        'ratio' => 0,
                    ],
                ],
            ],
            'family_cover' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => 16 / 9,
                    ],
                ],
            ],
            'banner' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => 200 / 24,
                    ],
                ],
            ],
            'membership_banner_image' => [
                'desktop' => [
                    [
                        'name' => 'desktop',
                        'ratio' => 0,
                    ],
                ],
            ],
            'listing_image' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => 16 / 9,
                    ],
                ],
            ],
            'dining_cover' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => 16 / 9,
                    ],
                ],
            ],
            'experience_image' => [
                'default' => [
                    [
                        'name' => 'Uncropped',
                        'ratio' => null,
                    ],
                ],
            ],
        ],
        'files' => [
            'attachment',
            'video',
            'image_sequence_file',
        ],
        'browser_route_prefixes' => [
            'events' => 'exhibitions_events',
            'selections' => 'collection',
            'artworks' => 'collection',
            'digitalLabels' => 'collection',
        ],
    ],

    'buckets' => [
        'homepage' => [
            'name' => 'Home',
            'buckets' => [
                'home_main_features' => [
                    'name' => 'Home main feature',
                    'bucketables' => [
                        [
                            'module' => 'homeFeatures',
                            'name' => 'Home Features',
                        ],
                    ],
                    'max_items' => 5,
                ],
                'home_art_and_ideas' => [
                    'name' => 'The Collection',
                    'bucketables' => [
                        [
                            'module' => 'articles',
                            'name' => 'Articles',
                            'scopes' => ['published' => true],
                        ],
                        [
                            'module' => 'selections',
                            'name' => 'Highlights',
                            'scopes' => ['published' => true],
                        ],
                    ],
                    'max_items' => 6,
                ],
            ],
        ],

        'art_and_ideas' => [
            'name' => 'The Collection',
            'buckets' => [
                'art_and_ideas_main_features' => [
                    'name' => 'The Collection featured articles',
                    'bucketables' => [
                        [
                            'module' => 'articles',
                            'name' => 'Articles',
                            'scopes' => ['published' => true],
                        ],
                    ],
                    'max_items' => 2,
                ],
            ],
        ],
    ],

    'dashboard' => [
        'modules' => [
            'events' => [
                'name' => 'events',
                'routePrefix' => 'exhibitions_events',
                'count' => true,
                'create' => true,
                'search' => true,
                'activity' => true,
                'drafts' => true,
            ],
            'articles' => [
                'name' => 'articles',
                'routePrefix' => 'collection.articles_publications',
                'count' => true,
                'create' => true,
                'search' => true,
                'activity' => true,
                'drafts' => true,
            ],
            'exhibitions' => [
                'name' => 'exhibitions',
                'routePrefix' => 'exhibitions_events',
                'count' => false,
                'create' => false,
                'search' => true,
                'search_fields' => ['title', 'datahub_id'],
                'activity' => true,
                'drafts' => false,
            ],
            'artists' => [
                'name' => 'artists',
                'routePrefix' => 'collection',
                'count' => false,
                'create' => false,
                'search' => true,
                'search_fields' => ['title', 'datahub_id'],
                'activity' => true,
                'drafts' => false,
            ],
            'genericPages' => [
                'label' => 'Generic pages',
                'label_singular' => 'Generic page',
                'name' => 'genericPages',
                'routePrefix' => 'generic',
                'count' => true,
                'create' => true,
                'search' => true,
                'activity' => true,
                'drafts' => true,
            ],
        ],
    ],

    'seo' => [
        'site_title' => 'Art Institute of Chicago',
        'site_desc' => '',
        'image' => 'https://artic-web.imgix.net/905abd91-5c0d-451b-9319-f7cd1505bc33/IM026911_002-web.jpg',
        'width' => 7500,
        'height' => 5000,
    ],
];

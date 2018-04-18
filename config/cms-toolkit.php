<?php

return [
    'auth_login_redirect_path' => '/featured/homepage',

    'templates_on_frontend_domain' => true,

    'frontend' => [
        'dev_assets_path' => '/dist',
    ],

    'enabled' => [
        'buckets' => true,
        'media-library' => true,
        'file-library' => true,
    ],

    'block_editor' => [
        'block_single_layout' => 'layouts.block',
        'block_preview_render_childs' => false,
        'blocks' => [
            'quote' => [
                'title' => 'Quote',
                'icon' => 'text',
                'component' => 'a17-block-quote',
            ],
            'image' => [
                'title' => 'Image',
                'icon' => 'image',
                'component' => 'a17-block-image',
            ],
            'video' => [
                'title' => 'Video',
                'icon' => 'image',
                'component' => 'a17-block-video',
            ],
            'accordion' => [
                'title' => 'Accordion',
                'icon' => 'text',
                'component' => 'a17-block-accordion',
            ],
            'gallery' => [
                'title' => 'Gallery',
                'icon' => 'image',
                'component' => 'a17-block-gallery',
            ],
            'list' => [
                'title' => 'List',
                'icon' => 'text',
                'component' => 'a17-block-list',
            ],
            'media_embed' => [
                'title' => 'Media embed',
                'icon' => 'text',
                'component' => 'a17-block-media_embed',
            ],
            'membership_banner' => [
                'title' => 'Membership banner',
                'icon' => 'text',
                'component' => 'a17-block-membership_banner',
            ],
            'paragraph' => [
                'title' => 'Paragraph',
                'icon' => 'text',
                'component' => 'a17-block-paragraph',
            ],
            'citation' => [
                'title' => 'Citation',
                'icon' => 'text',
                'component' => 'a17-block-citation',
            ],
            'references' => [
                'title' => 'References',
                'icon' => 'text',
                'component' => 'a17-block-references',
            ],
            'timeline' => [
                'title' => 'Timeline',
                'icon' => 'text',
                'component' => 'a17-block-timeline',
            ],
            'link' => [
                'title' => 'Link',
                'icon' => 'text',
                'component' => 'a17-block-link',
            ],
            'plan_your_visit' => [
                'title' => 'Plan Your Visit',
                'icon' => 'text',
                'component' => 'a17-block-plan_your_visit',
            ],
            'newsletter_signup_footer' => [
                'title' => 'Newsletter signup footer',
                'icon' => 'text',
                'component' => 'a17-block-newsletter_signup_footer',
            ],
            'newsletter_signup_inline' => [
                'title' => 'Newsletter signup inline',
                'icon' => 'text',
                'component' => 'a17-block-newsletter_signup_inline',
            ],
            'footnote' => [
                'title' => 'Footnote',
                'icon' => 'text',
                'component' => 'a17-block-footnote',
            ],
            'event' => [
                'title' => 'Event',
                'icon' => 'text',
                'component' => 'a17-block-event',
            ],
            'artwork' => [
                'title' => 'Artwork',
                'icon' => 'image',
                'component' => 'a17-block-artwork',
            ],
            'artworks' => [
                'title' => 'Artworks gallery',
                'icon' => 'image',
                'component' => 'a17-block-artworks',
            ],
            'shop_items' => [
                'title' => 'Featured products',
                'icon' => 'image',
                'component' => 'a17-block-shop_items',
            ],
            'child_pages' => [
                'title' => 'Child pages link block',
                'icon' => 'image',
                'component' => 'a17-block-child_pages',
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
                'max' => 10,
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
            'timeline_item' => [
                'title' => 'Timeline Item',
                'trigger' => 'Add Timeline',
                'component' => 'a17-block-timeline_item',
                'max' => 10,
            ],
        ],
        'crops' => [
            'image' => [
                'desktop' => [
                    [
                        'name' => 'desktop',
                        'ratio' => 16 / 9,
                    ],
                ],
                'mobile' => [
                    [
                        'name' => 'mobile',
                        'ratio' => 1,
                    ],
                ],
            ],
            'family_cover' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => 16 / 9,
                    ],
                ]
            ],
            'banner' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => 200 / 24,
                    ],
                ]
            ],
            'listing_image' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => 16 / 9,
                    ],
                ]
            ],
            'dining_cover' => [
                'default' => [
                    [
                        'name' => 'default',
                        'ratio' => 3 / 4,
                    ],
                ]
            ],
        ],
        'files' => [
            'attachment',
            'video'
        ],
        'browser_route_prefixes' => [
            'events' => 'exhibitions_events',
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
                            'name' => 'Home Features'
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
                            'name' => 'Selections',
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
];

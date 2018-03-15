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
        'blocks' => [
            'text' => [
                'title' => 'Text',
                'icon' => 'text',
                'component' => 'a17-block-text',
            ],
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
                'title' => 'Media Embed',
                'icon' => 'text',
                'component' => 'a17-block-media_embed',
            ],
            'membership_banner' => [
                'title' => 'Membership Banner',
                'icon' => 'text',
                'component' => 'a17-block-membership_banner',
            ],
            'related_offers' => [
                'title' => 'Related Offers',
                'icon' => 'text',
                'component' => 'a17-block-related_offers',
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
                'title' => 'link',
                'icon' => 'text',
                'component' => 'a17-block-link',
            ],
            'plan_your_visit' => [
                'title' => 'Plan Your Visit',
                'icon' => 'text',
                'component' => 'a17-block-plan_your_visit',
            ],
            'newsletter_signup_footer' => [
                'title' => 'Newsletter Signup Footer',
                'icon' => 'text',
                'component' => 'a17-block-newsletter_signup_footer',
            ],
            'newsletter_signup_inline' => [
                'title' => 'Newsletter Signup Inline',
                'icon' => 'text',
                'component' => 'a17-block-newsletter_signup_inline',
            ],
            'sponsor' => [
                'title' => 'Sponsor',
                'icon' => 'text',
                'component' => 'a17-block-sponsor',
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
                'title' => 'Artworks Gallery',
                'icon' => 'image',
                'component' => 'a17-block-artworks',
            ],
            'shop_item' => [
                'title' => 'Shop Item',
                'icon' => 'image',
                'component' => 'a17-block-shop_item',
            ],
            'shop_items' => [
                'title' => 'Shop Items',
                'icon' => 'image',
                'component' => 'a17-block-shop_items',
            ],
            'child_pages' => [
                'title' => 'Child Pages Link Block',
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
                'title' => 'Locations',
                'trigger' => 'Add locations',
                'component' => 'a17-block-locations',
                'max' => 10,
            ],
            'featured_hours' => [
                'title' => 'Featured Hours',
                'trigger' => 'Add featured hours',
                'component' => 'a17-block-featured_hours',
                'max' => 10,
            ],
            'dinning_hours' => [
                'title' => 'Dinning Hours',
                'trigger' => 'Add dinning hours',
                'component' => 'a17-block-dinning_hours',
                'max' => 3,
            ],
            'accordion_item' => [
                'title' => 'Accordion Item',
                'trigger' => 'Add accordion',
                'component' => 'a17-block-accordion_item',
                'max' => 10,
            ],
            'list_item' => [
                'title' => 'List Item',
                'trigger' => 'Add list',
                'component' => 'a17-block-list_item',
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
        ],
        'browser_route_prefixes' => [
            'events' => 'whatson',
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
                    'name' => 'Art and Ideas',
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
            'name' => 'Art and Ideas',
            'buckets' => [
                'art_and_ideas_main_features' => [
                    'name' => 'Art and Ideas featured articles',
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

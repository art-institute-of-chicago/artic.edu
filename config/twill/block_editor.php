<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Twill Block Editor configuration
    |--------------------------------------------------------------------------
    |
    | This array allows you to provide the package with your configuration
    | for the Block editor field and Editor features.
    |
     */

    'block_single_layout' => 'layouts.block',
    'block_preview_render_childs' => false,
    'block_presenter_path' => App\Presenters\Admin\BlockPresenter::class, // allow to set a custom presenter to a block model
    // Indicates if blocks templates should be inlined in HTML.
    // When setting to false, make sure to build Twill with your all your custom blocks.
    'inline_blocks_templates' => true,
    'custom_vue_blocks_resource_path' => 'assets/js/blocks',
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
        'feature_2x' => [
            'title' => 'Feature 2x',
            'icon' => 'image',
            'component' => 'a17-block-feature_2x',
        ],
        'feature_4x' => [
            'title' => 'Feature 4x',
            'icon' => 'image',
            'component' => 'a17-block-feature_4x',
        ],
        'grid' => [
            'title' => 'Grid',
            'icon' => 'image',
            'component' => 'a17-block-grid',
        ],
        'gallery_new' => [
            'title' => 'Gallery (new)',
            'icon' => 'image',
            'component' => 'a17-block-gallery_new',
        ],
        'gallery' => [
            'title' => 'Gallery (old)',
            'icon' => 'image',
            'component' => 'a17-block-gallery',
        ],
        'artworks' => [
            'title' => 'Artworks gallery (old)',
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
        'links-bar' => [
            'title' => 'Links bar',
            'icon' => 'text',
            'component' => 'a17-block-links-bar',
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
        'magazine_item' => [
            'title' => 'Magazine Item',
            'icon' => 'text',
            'component' => 'a17-block-magazine_item'
        ],
        'magazine_call_to_action' => [
            'title' => 'Magazine Call to Action',
            'icon' => 'text',
            'component' => 'a17-block-magazine_call_to_action'
        ],
        'event' => [
            'title' => 'Event',
            'icon' => 'text',
            'component' => 'a17-block-event',
        ],
        'events' => [
            'title' => 'Events',
            'icon' => 'text',
            'component' => 'a17-block-events',
        ],
        'exhibitions' => [
            'title' => 'Exhibitions',
            'icon' => 'text',
            'component' => 'a17-block-exhibitions',
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
        'footnote' => [
            'title' => 'Footnote',
            'icon' => 'text',
            'component' => 'a17-block-footnote',
        ],
        'table' => [
            'title' => 'Table',
            'icon' => 'text',
            'component' => 'a17-block-table',
            // TODO: Look into `rules` per \A17\Twill\ValidationServiceProvider
        ],
        'digital_label' => [
            'title' => 'Interactive feature',
            'icon' => 'image',
            'component' => 'a17-block-digital_label',
        ],
        '3d_model' => [
            'title' => '3D Model',
            'icon' => 'image',
            'component' => 'a17-block-aic_3d_model'
        ],
        '3d_tour' => [
            'title' => '3D Tour',
            'icon' => 'image',
            'component' => 'a17-block-aic_3d_tour'
        ],
        '3d_embed' => [
            'title' => '3D Embed',
            'icon' => 'image',
            'component' => 'a17-block-aic_3d_embed'
        ],
        '360_embed' => [
            'title' => '360 Embed',
            'icon' => 'image',
            'component' => 'a17-block-threesixty_embed'
        ],
        '360_modal' => [
            'title' => '360 Modal',
            'icon' => 'image',
            'component' => 'a17-block-threesixty_modal'
        ],
        'artists' => [
            'title' => 'Artists',
            'icon' => 'image',
            'component' => 'a17-block-artists'
        ],
        'image_slider' => [
            'title' => 'Image Slider',
            'icon' => 'image',
            'component' => 'a17-block-image_slider'
        ],
        'mirador_embed' => [
            'title' => 'Mirador Embed',
            'icon' => 'image',
            'component' => 'a17-block-mirador_embed'
        ],
        'mirador_modal' => [
            'title' => 'Mirador Modal',
            'icon' => 'image',
            'component' => 'a17-block-mirador_modal'
        ],
        'vtour_embed' => [
            'title' => 'Virtual Tour Embed',
            'icon' => 'image',
            'component' => 'a17-block-vtour_embed'
        ],
    ],
    'use_twill_blocks' => ['text', 'image'],
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
                    'name' => 'free',
                    'ratio' => null,
                ],
                [
                    'name' => '16:9',
                    'ratio' => 16 / 9
                ],
                [
                    'name' => '9:16',
                    'ratio' => 9 / 16
                ],
                [
                    'name' => '4:3',
                    'ratio' => 4 / 3
                ],
                [
                    'name' => '1:1',
                    'ratio' => 1 / 1
                ],
                [
                    'name' => '3:4',
                    'ratio' => 3 / 4
                ]
            ]
        ],
        'artist_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 3 / 4,
                ],
            ],
        ],
        'left_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => null,
                ],
            ],
        ],
        'right_image' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => null,
                ],
            ],
        ],

    ],
    'directories' => [
        'source' => [
            'blocks' => [
                [
                    'path' => base_path('vendor/area17/twill/src/Commands/stubs/blocks'),
                    'source' => A17\Twill\Services\Blocks\Block::SOURCE_TWILL,
                ],
                [
                    'path' => resource_path('views/admin/blocks'),
                    'source' => A17\Twill\Services\Blocks\Block::SOURCE_APP,
                ],
            ],

            'repeaters' => [
                [
                    'path' => resource_path('views/admin/repeaters'),
                    'source' => A17\Twill\Services\Blocks\Block::SOURCE_APP,
                ],
                [
                    'path' => base_path('vendor/area17/twill/src/Commands/stubs/repeaters'),
                    'source' => A17\Twill\Services\Blocks\Block::SOURCE_TWILL,
                ],
            ],

            'icons' => [
                base_path('vendor/area17/twill/frontend/icons'),
                resource_path('views/admin/icons'),
            ],
        ],

        'destination' => [
            'make_dir' => true,

            'blocks' => resource_path('views/admin/blocks'),

            'repeaters' => resource_path('views/admin/repeaters'),
        ],
    ],
    'files' => [
        'attachment',
        'video',
        'image_sequence_file',
        'upload_manifest_file',
        'vtour_xml_file',
    ],
];

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
    'block_views_path' => 'site.blocks', // Path where a view file per block type is stored
    'block_views_mappings' => [], // Custom mapping of block types and views
    'block_preview_render_childs' => false,
    'block_presenter_path' => App\Presenters\Admin\BlockPresenter::class, // Allow to set a custom presenter to a block model
    // Indicates if blocks templates should be inlined in HTML.
    // When setting to false, make sure to build Twill with your all your custom blocks.
    'inline_blocks_templates' => true,
    'custom_vue_blocks_resource_path' => 'assets/js/blocks',
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
    'repeaters' => [],
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
        'audio_file',
        'image_sequence_file',
        'upload_manifest_file',
        'vtour_xml_file',
    ],
    'browser_route_prefixes' => [
        'events' => 'exhibitions_events',
        'exhibitions' => 'exhibitions_events',
        'highlights' => 'collection',
        'artworks' => 'collection',
        'authors' => 'collection',
        'highlights' => 'collection',
        'articles' => 'collection.articles_publications',
        'experiences' => 'collection.interactive_features',
        'landingPages' => 'generic.landingPages',
        'genericPages' => 'generic.genericPages',
    ],
    'block-order' => [
        '3d_embed',
        '3d_model',
        '3d_tour',
        '360_embed',
        '360_modal',
        'accordion',
        'artwork',
        'artists',
        'audio_player',
        'button',
        'child_pages',
        'citation',
        'collection_block',
        'custom_banner',
        'digital_label',
        'event',
        'events',
        'exhibitions',
        'feature_2x',
        'feature_4x',
        'feature_block',
        'featured_pages_grid',
        'footnote',
        'gallery_new',
        'grid',
        'hr',
        'image',
        'image_slider',
        'layered_image_viewer',
        'link',
        'links-bar',
        'list',
        'magazine_call_to_action',
        'magazine_item',
        'media_embed',
        'membership_banner',
        'mirador_embed',
        'mirador_modal',
        'newsletter_signup_inline',
        'paragraph',
        'quote',
        'references',
        'search_bar',
        'showcase',
        'split_block',
        'table',
        'threesixty_embed',
        'threesixty_modal',
        'timeline',
        'tour_stop',
        'video',
        'vtour_embed'
    ]
];

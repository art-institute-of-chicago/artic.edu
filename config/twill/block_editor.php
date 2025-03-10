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
    'block_presenter_path' => App\Presenters\Admin\BlockPresenter::class, // Allow to set a custom presenter to a block model
    // Indicates if blocks templates should be inlined in HTML.
    // When setting to false, make sure to build Twill with your all your custom blocks.
    'inline_blocks_templates' => true,
    'custom_vue_blocks_resource_path' => 'assets/js/blocks',
    'use_twill_blocks' => ['text', 'image'],
    'crops' => [],
    'repeaters' => [],

    'core_icons' => base_path('frontend/icons'),

    'directories' => [
        'source' => [
            'blocks' => [
                [
                    'path' => base_path('vendor/area17/twill/src/Commands/stubs/blocks'),
                    'source' => A17\Twill\Services\Blocks\Block::SOURCE_TWILL,
                ],
                [
                    'path' => resource_path('views/twill/blocks'),
                    'source' => A17\Twill\Services\Blocks\Block::SOURCE_APP,
                ],
            ],

            'repeaters' => [
                [
                    'path' => resource_path('views/twill/repeaters'),
                    'source' => A17\Twill\Services\Blocks\Block::SOURCE_APP,
                ],
                [
                    'path' => base_path('vendor/area17/twill/src/Commands/stubs/repeaters'),
                    'source' => A17\Twill\Services\Blocks\Block::SOURCE_TWILL,
                ],
            ],

            'icons' => [
                base_path('frontend/icons'),
                resource_path('views/twill/icons'),
            ],
        ],

        'destination' => [
            'make_dir' => true,

            'blocks' => resource_path('views/twill/blocks'),

            'repeaters' => resource_path('views/twill/repeaters'),
        ],
    ],
    'files' => [
        'attachment',
        'video',
        'audio_file',
        'image_sequence_file',
        'upload_manifest_file',
    ],
    'browser_route_prefixes' => [
        'digitalPublications' => 'collection.articlesPublications',
        'printedPublications' => 'collection.articlesPublications',
        'events' => 'exhibitionsEvents',
        'exhibitions' => 'exhibitionsEvents',
        'highlights' => 'collection',
        'artworks' => 'collection',
        'authors' => 'collection',
        'articles' => 'collection.articlesPublications',
        'experiences' => 'collection.interactiveFeatures',
        'landingPages' => 'generic',
        'genericPages' => 'generic',
        'videos' => 'collection.articlesPublications',
        'myMuseumTourItems' => 'visit',
    ],
    'block-order' => [
        'paragraph',
        'image',
        'hr',
        'artwork',
        'split_block',
        'gallery_new',
        'link',
        'video',
        'quote',
        'tour_stop',
        'accordion',
        'media_embed',
        'list',
        'timeline',
        'child_pages',
        'grid',
        'image_slider',
        'exhibitions',
        'events',
        'button',
        'newsletter_signup_inline',
        'magazine_call_to_action',
        'table',
        'audio_player',
        '360_embed',
        'mirador_embed',
        '3d_embed',
        'custom_banner',
        'event',
        'search_bar',
        'feature_2x',
        'membership_banner',
        'showcase',
        'layered_image_viewer',
        'feature_block',
        '3d_tour',
        'references',
        '3d_model',
        'stories_block',
        'featured_pages_grid',
        'feature_4x',
        'collection_block',
        'citation',
        'links-bar',
        'mobile_app',
        'magazine_item',
        'threesixty_embed',
        'threesixty_modal',
        'mirador_modal',
        'tours_grid',
        'footnote',
        'artists',
        'my_museum_tour_grid',
        'digital_label',
        'magazine_call_to_action',
        'threesixty_modal',
        '360_modal',
        'editorial_block',
        'tombstone',
        'ranged_accordion',
    ]
];

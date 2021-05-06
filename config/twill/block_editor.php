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
        'feature_2x' => [
            'title' => 'Feature 2x',
            'icon' => 'image',
            'component' => 'a17-block-feature_2x',
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
            'title' => 'Explore on your own',
            'trigger' => 'Add item',
            'component' => 'a17-block-families',
            'max' => 3,
        ],
        'whatToExpects' => [
            'title' => 'What to Expect',
            'trigger' => 'Add item',
            'component' => 'a17-block-what_to_expect',
            'max' => 9,
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
        'grid_item' => [
            'title' => 'Grid Item',
            'trigger' => 'Add Grid Item',
            'component' => 'a17-block-grid_item',
            'max' => 48,
        ],
        'gallery_new_item' => [
            'title' => 'Gallery Item',
            'trigger' => 'Add gallery item',
            'component' => 'a17-block-gallery_new_item',
        ],
        'gallery_item' => [
            'title' => 'Gallery Item',
            'trigger' => 'Add Image',
            'component' => 'a17-block-gallery_item',
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
            'title' => 'Image',
            'trigger' => 'Add Image',
            'component' => 'a17-block-experience_image_with_caption',
            'max' => 1,
        ],
        'modal_experience_image' => [
            'title' => 'Image',
            'trigger' => 'Add Image',
            'component' => 'a17-block-experience_image_with_caption',
            'max' => 4,
        ],
        'seamless_experience_image' => [
            'title' => 'Image',
            'trigger' => 'Add Image',
            'component' => 'a17-block-experience_image',
            'max' => 1,
        ],
        'interstitial_experience_image' => [
            'title' => 'Image',
            'trigger' => 'Add Image',
            'component' => 'a17-block-experience_image_with_caption',
            'max' => 1,
        ],
        'fullwidthmedia_experience_image' => [
            'title' => 'Image',
            'trigger' => 'Add Image',
            'component' => 'a17-block-experience_image_with_caption',
            'max' => 1,
        ],
        'tooltip_experience_image' => [
            'title' => 'Image',
            'trigger' => 'Add Image',
            'component' => 'a17-block-experience_image_with_caption',
            'max' => 1,
        ],
        'attract_experience_image' => [
            'title' => 'Image',
            'trigger' => 'Add Image',
            'component' => 'a17-block-experience_image_with_caption',
            'max' => 3,
        ],
        'end_experience_image' => [
            'title' => 'Image',
            'trigger' => 'Add Image',
            'component' => 'a17-block-experience_image_with_caption',
            'max' => 3,
        ],
        'end_bg_experience_image' => [
            'title' => 'Background Image',
            'trigger' => 'Add Background Image',
            'component' => 'a17-block-experience_image_with_caption',
            'max' => 1,
        ],
        'slide_primary_experience_image' => [
            'title' => 'Primary Image',
            'trigger' => 'Add Primary Image',
            'component' => 'a17-block-experience_image_with_caption',
            'max' => 1,
        ],
        'slide_secondary_experience_image' => [
            'title' => 'Secondary Image',
            'trigger' => 'Add Secondary Image',
            'component' => 'a17-block-experience_image_with_caption',
            'max' => 1,
        ],
        'compare_experience_image_1' => [
            'title' => 'Compare Image 1',
            'trigger' => 'Add Compare Image 1',
            'component' => 'a17-block-experience_image_with_caption',
            'max' => 1,
        ],
        'compare_experience_image_2' => [
            'title' => 'Compare Image 2',
            'trigger' => 'Add Compare Image 2',
            'component' => 'a17-block-experience_image_with_caption',
            'max' => 1,
        ],
        'compare_experience_modal' => [
            'title' => 'Compare experience modal',
            'trigger' => 'Add Compare Experience Modal',
            'component' => 'a17-block-experience_image_with_caption',
            'max' => 2,
        ],
        'experience_modal' => [
            'title' => 'Experience Modal',
            'trigger' => 'Add Experience Modal',
            'component' => 'a17-block-experience_modal',
            'max' => 1,
        ],
        'primary_experience_modal' => [
            'title' => 'Primary Experience Modal',
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
        'homeArtists' => [
            'title' => 'Artists',
            'trigger' => 'Add Artist',
            'component' => 'a17-block-artists',
            'max' => 10,
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
    'files' => [
        'attachment',
        'video',
        'image_sequence_file',
        'upload_manifest_file',
        'vtour_xml_file',
    ],
    'browser_route_prefixes' => [
        'events' => 'exhibitions_events',
        'exhibitions' => 'exhibitions_events',
        'selections' => 'collection',
        'artworks' => 'collection',
        'authors' => 'collection',
        'selections' => 'collection',
        'articles' => 'collection.articles_publications',
        'experiences' => 'collection.interactive_features',
    ],
];

@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Display date',
        'required' => true,
        'withTime' => false,
        'note' => 'Required',
    ])

    @formField('select', [
        'name' => 'article_type',
        'label' => 'Type',
        'placeholder' => 'Select a type',
        'default' => 'text',
        'options' => $types,
    ])
@stop

@section('fieldsets')
    @formConnectedFields([
        'fieldName' => 'article_type',
        'fieldValues' => 'grouping',
        'renderForBlocks' => false,
    ])
        @formFieldset([
            'id' => 'fields-for-type-grouping',
            'title' => 'Grouping fields',
        ])
            @formField('select', [
                'name' => 'listing_display',
                'label' => 'Listing display',
                'placeholder' => 'Select a listing display',
                'default' => 'default',
                'options' => [
                    ['value' => 'feature', 'label' => 'Feature'],
                    ['value' => '3-across', 'label' => '3-Across'],
                    ['value' => 'entries', 'label' => 'Entries'],
                    ['value' => 'group_entries', 'label' => 'Group of Entries'],
                    ['value' => 'list', 'label' => 'List view'],
                    ['value' => 'simple_list', 'label' => 'Text list view'],
                ],
            ])

            @formField('wysiwyg', [
                'name' => 'grouping_description',
                'label' => 'Description',
                'maxlength' => 255,
                'note' => 'Max 255 characters',
                'toolbarOptions' => [
                    'italic', 'link',
                ],
            ])

            @formField('medias', [
                'with_multiple' => false,
                'no_crop' => false,
                'label' => 'Grouping image',
                'name' => 'grouping_hero',
                'note' => 'Minimum image width 3000px'
            ])

            @formField('medias', [
                'with_multiple' => false,
                'no_crop' => false,
                'label' => 'Mobile grouping image',
                'name' => 'grouping_mobile_hero',
                'note' => 'Minimum image width 2000px'
            ])
        @endformFieldset
    @endformConnectedFields

    @formConnectedFields([
        'fieldName' => 'article_type',
        'fieldValues' => 'entry',
        'renderForBlocks' => false,
    ])
        @formFieldset([
            'id' => 'fields-for-type-entry',
            'title' => 'Entry fields',
        ])
            @formField('medias', [
                'with_multiple' => false,
                'no_crop' => false,
                'label' => 'Listing image',
                'name' => 'hero',
                'note' => 'Minimum image width 3000px'
            ])

            @formField('medias', [
                'with_multiple' => false,
                'no_crop' => false,
                'label' => 'Mobile listing image',
                'name' => 'mobile_hero',
                'note' => 'Minimum image width 2000px'
            ])

            @component('twill::partials.form.utils._columns')
                @slot('left')
                    @formField('checkbox', [
                        'name' => 'hide_title',
                        'label' => 'Hide title in listing view',
                    ])
                @endslot

                @slot('right')
                    @formField('checkbox', [
                        'name' => 'suppress_listing',
                        'label' => 'Hide from listing view',
                    ])
                @endslot
            @endcomponent

            @formField('input', [
                'name' => 'label',
                'label' => 'Article label',
                'note' => 'Used in the "eyebrow" of cards on the publication page',
            ])

            @formField('wysiwyg', [
                'name' => 'list_description',
                'label' => 'List description',
                'maxlength' => 255,
                'note' => 'Max 255 characters. Will be used on the main landing, search, and social media.',
                'toolbarOptions' => [
                    'italic',
                ],
            ])

            @formField('input', [
                'name' => 'author_display',
                'label' => 'Author display',
                'note' => 'On Entry type articles, authorship is prepended with "Entry by"',
            ])

            @formField('browser', [
                'routePrefix' => 'collection',
                'moduleName' => 'authors',
                'name' => 'authors',
                'label' => 'Authors',
                'max' => 10,
                'note' => 'On Entry type articles, authorship is prepended with "Entry by"',
            ])

            @formField('wysiwyg', [
                'name' => 'cite_as',
                'label' => 'How to Cite',
                'toolbarOptions' => [
                    'italic',
                ],
            ])

            @formField('wysiwyg', [
                'name' => 'references',
                'label' => 'References',
                'toolbarOptions' => [
                    'italic', 'link', 'list-ordered', 'list-unordered',
                ],
            ])

            @formField('block_editor', [
                'blocks' => BlockHelpers::getBlocksForEditor([
                    '360_embed',
                    '360_modal',
                    '3d_embed',
                    '3d_model',
                    '3d_tour',
                    'ranged_accordion',
                    'artwork',
                    'audio_player',
                    'button',
                    'citation',
                    'digital_label',
                    'gallery_new',
                    'hr',
                    'image',
                    'image_slider',
                    'layered_image_viewer',
                    'links-bar',
                    'list',
                    'media_embed',
                    'membership_banner',
                    'mirador_embed',
                    'mirador_modal',
                    'mobile_app',
                    'paragraph',
                    'quote',
                    'split_block',
                    'table',
                    'tombstone',
                    'tour_stop',
                    'video',
                ])
            ])
        @endformFieldset
    @endformConnectedFields

    @formConnectedFields([
        'fieldName' => 'article_type',
        'fieldValues' => ['about', 'text', 'work'],
        'renderForBlocks' => false,
    ])
        @formFieldset([
            'id' => 'fields-for-type-other',
            'title' => 'Article fields',
        ])
            @formField('medias', [
                'with_multiple' => false,
                'no_crop' => false,
                'label' => 'Hero image',
                'name' => 'hero',
                'note' => 'Minimum image width 3000px'
            ])

            @formField('medias', [
                'with_multiple' => false,
                'no_crop' => false,
                'label' => 'Mobile hero image',
                'name' => 'mobile_hero',
                'note' => 'Minimum image width 2000px'
            ])

            @component('twill::partials.form.utils._columns')
                @slot('left')
                    @formField('checkbox', [
                        'name' => 'hide_title',
                        'label' => 'Hide title in listing view',
                    ])
                @endslot

                @slot('right')
                    @formField('checkbox', [
                        'name' => 'suppress_listing',
                        'label' => 'Hide from listing view',
                    ])
                @endslot
            @endcomponent

            @formField('input', [
                'name' => 'label',
                'label' => 'Article label',
                'note' => 'Used in the "eyebrow" of cards on the publication page',
            ])

            @formField('wysiwyg', [
                'name' => 'list_description',
                'label' => 'List description',
                'maxlength' => 255,
                'note' => 'Max 255 characters. Will be used on the main landing, search, and social media.',
                'toolbarOptions' => [
                    'italic',
                ],
            ])

            @formField('input', [
                'name' => 'author_display',
                'label' => 'Author display',
            ])

            @formField('browser', [
                'routePrefix' => 'collection',
                'moduleName' => 'authors',
                'name' => 'authors',
                'label' => 'Authors',
                'max' => 10,
            ])

            @formField('wysiwyg', [
                'name' => 'cite_as',
                'label' => 'How to Cite',
                'toolbarOptions' => [
                    'italic',
                ],
            ])

            @formField('wysiwyg', [
                'name' => 'references',
                'label' => 'References',
                'toolbarOptions' => [
                    'italic', 'link', 'list-ordered', 'list-unordered',
                ],
            ])

            @formField('block_editor', [
                'blocks' => BlockHelpers::getBlocksForEditor([
                    '360_embed',
                    '360_modal',
                    '3d_embed',
                    '3d_model',
                    '3d_tour',
                    'ranged_accordion',
                    'artwork',
                    'audio_player',
                    'button',
                    'citation',
                    'digital_label',
                    'gallery_new',
                    'hr',
                    'image',
                    'image_slider',
                    'layered_image_viewer',
                    'links-bar',
                    'list',
                    'media_embed',
                    'membership_banner',
                    'mirador_embed',
                    'mirador_modal',
                    'mobile_app',
                    'paragraph',
                    'quote',
                    'split_block',
                    'table',
                    'tombstone',
                    'tour_stop',
                    'video',
                ])
            ])
        @endformFieldset
    @endformConnectedFields

    @include('admin.partials.meta')
@stop

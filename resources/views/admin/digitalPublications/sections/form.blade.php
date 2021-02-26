@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('input', [
        'name' => 'short_title_display',
        'label' => 'Short title',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Display date',
        'optional' => false,
        'withTime' => false,
        'note' => 'Required',
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('select', [
        'name' => 'type',
        'label' => 'Type',
        'placeholder' => 'Select a type',
        'default' => 'text',
        'options' => $typesList,
    ])

    @formField('wysiwyg', [
        'name' => 'list_description',
        'label' => 'List description',
        'maxlength' => 255,
        'note' => 'Max 255 characters. Will be used on the issue landing, search, and social media.',
        'toolbarOptions' => [
            'italic'
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
        'max' => 10
    ])

    @formField('wysiwyg', [
        'name' => 'cite_as',
        'label' => 'Recommended citation',
        'toolbarOptions' => [
            'italic'
        ],
    ])

@formField('wysiwyg', [
    'name' => 'bibliography',
    'label' => 'Bibliography',
    'toolbarOptions' => [
        'italic', 'link', 'list-ordered', 'list-unordered'
    ],
])

    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            'paragraph', 'image', 'video', 'media_embed', 'quote',
            'list', 'artwork', 'hr', 'citation', 'split_block',
            'membership_banner', 'digital_label', 'tour_stop', 'button', 'mobile_app',
            '3d_model', '3d_tour', '3d_embed', '360_embed', '360_modal',
            'gallery', 'artworks', 'gallery_new',
            'image_slider', 'mirador_embed', 'mirador_modal',
        ])
    ])

@stop

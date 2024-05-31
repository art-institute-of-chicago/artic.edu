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

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Mobile hero image',
        'name' => 'mobile_hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('select', [
        'name' => 'type',
        'label' => 'Type',
        'placeholder' => 'Select a type',
        'default' => 'text',
        'options' => $types,
    ])

    @formField('input', [
        'name' => 'type_display',
        'label' => 'Article label',
        'note' => 'Used in the "eyebrow" of cards on the publication page',
    ])

    @formField('wysiwyg', [
        'name' => 'list_description',
        'label' => 'List description',
        'maxlength' => 255,
        'note' => 'Max 255 characters. Will be used on the main landing, search, and social media.',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'heading',
        'label' => 'Heading',
        'note' => 'Only intended for Works sections.',
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
        'label' => 'How to Cite',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'references',
        'label' => 'References',
        'toolbarOptions' => [
            'italic', 'link', 'list-ordered', 'list-unordered'
        ],
    ])

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'hr', 'artwork', 'split_block', 'gallery_new', 'video', 'quote', 'tour_stop', 'media_embed', 'list', 'image_slider', 'button', 'table', 'audio_player', '360_embed', 'mirador_embed', '3d_embed', 'membership_banner', 'layered_image_viewer', '3d_tour', '3d_model', 'citation', 'links-bar', 'mobile_app', 'mirador_modal', 'digital_label', '360_modal'
        ])
    ])
@stop

@section('fieldsets')

    @include('admin.partials.meta')

@stop

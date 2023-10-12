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
        'options' => $typesList,
    ])

    @formField('input', [
        'name' => 'type_display',
        'label' => 'Section label',
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
        '3d_embed',
        '3d_model',
        '3d_tour',
        '360_embed',
        '360_modal',
        'artwork',
        'audio_player',
        'button',
        'citation',
        'digital_label',
        'gallery_new',
        'hr',
        'image',
        'image_slider',
        'list',
        'layered_image_viewer',
        'links-bar',
        'media_embed',
        'membership_banner',
        'mirador_embed',
        'mirador_modal',
        'mobile_app',
        'paragraph',
        'quote',
        'split_block',
        'table',
        'tour_stop',
        'video'
        ])
    ])
@stop

@section('fieldsets')

    @include('admin.partials.meta')

@stop

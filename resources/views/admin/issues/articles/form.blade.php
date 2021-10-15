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

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Mobile hero image',
        'name' => 'mobile_hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('input', [
        'name' => 'type_display',
        'label' => 'Article label',
        'note' => 'Used for article cards on the issue page. Defaults to "Article" if empty.',
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

    @formField('wysiwyg', [
        'name' => 'description',
        'label' => 'Description',
        'note' => 'Appears below title on the article detail page.',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('input', [
        'name' => 'abstract',
        'label' => 'Abstract',
        'type' => 'textarea',
        'note' => 'Appears in italics below the description on article detail.',
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

    @formField('input', [
        'name' => 'review_status',
        'label' => 'Review status',
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'License image',
        'name' => 'license',
    ])

    @formField('input', [
        'name' => 'license_text',
        'label' => 'License text',
    ])

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'video', 'media_embed', 'quote',
            'list', 'artwork', 'hr', 'citation', 'split_block',
            'membership_banner', 'digital_label', 'audio_player', 'tour_stop', 'button', 'mobile_app',
            '3d_model', '3d_tour', '3d_embed', '360_embed', '360_modal',
            'gallery_new', 'table',
            'image_slider', 'mirador_embed', 'mirador_modal',
        ])
    ])

@stop

@section('fieldsets')

    @include('admin.partials.meta')

@stop

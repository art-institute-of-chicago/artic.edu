@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related']
    ]
])

@section('contentFields')
    @formField('input', [
        'name' => 'title',
        'label' => 'Title',
        'required' => true
    ])

    @formField('multi_select', [
        'name' => 'siteTags',
        'label' => 'Tags',
        'options' => $siteTagsList,
        'placeholder' => 'Select some tags',
    ])

    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('wysiwyg', [
        'name' => 'short_copy',
        'label' => 'Short intro copy',
        'maxlength' => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('medias', [
        'name' => 'hero',
        'label' => 'Hero image',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('wysiwyg', [
        'type' => 'textarea',
        'name' => 'hero_caption',
        'label' => 'Hero image Caption',
        'note' => 'Usually used for copyright',
        'maxlength' => 255,
        'toolbarOptions' => [
            'italic', 'link',
        ],
    ])

    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            'paragraph', 'image', 'gallery', 'video', 'media_embed',
            'artwork', 'artworks', 'hr', 'tour_stop', 'button'
        ])
    ])
@stop

@section('fieldsets')
    @component('admin.partials.featured-related', ['form_fields' => $form_fields])
        @slot('articles', 'articles')
        @slot('events', 'sidebarEvent')
        @slot('exhibitions', 'sidebarExhibitions')
        @slot('experiences', null)
        @slot('videos', 'videos')
    @endcomponent

    @include('admin.partials.meta')

@stop

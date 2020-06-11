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

    @include('admin.partials.hero')

    @formField('select', [
        'name' => 'highlight_type',
        'label' => 'Type',
        'options' => $highlightTypeList,
        'placeholder' => 'Select a type',
    ])

    @formField('checkbox', [
        'name' => 'is_unlisted',
        'label' => 'Don\'t show this highlight in listings',
    ])

    @formField('input', [
        'name' => 'author_display',
        'label' => 'Author display',
        'maxlength' => 255
    ])

    @formField('browser', [
        'routePrefix' => 'collection',
        'moduleName' => 'authors',
        'name' => 'authors',
        'label' => 'Authors',
        'max' => 10
    ])

    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            'paragraph', 'image', 'gallery', 'video', 'media_embed',
            'artwork', 'artworks', 'hr', 'tour_stop', 'button', '3d_model'
        ])
    ])
@stop

@section('fieldsets')
    @component('admin.partials.featured-related', ['form_fields' => $form_fields])
        @slot('routePrefix', 'collection')
        @slot('moduleName', 'selections')
    @endcomponent

    @include('admin.partials.meta')

@stop

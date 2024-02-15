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

    @formField('multi_select', [
        'name' => 'categories',
        'label' => 'Categories',
        'options' => $categoriesList,
        'placeholder' => 'Select some categories',
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

    @formField('checkbox', [
        'name' => 'is_in_magazine',
        'label' => 'Assume this highlight is featured in a magazine issue',
    ])

    @include('admin.partials.authors')

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            '3d_model',
            'artwork',
            'audio_player',
            'button',
            'event',
            'feature_2x',
            'feature_4x',
            'gallery_new',
            'grid',
            'hr',
            'image',
            'layered_image_viewer',
            'list',
            'media_embed',
            'paragraph',
            'quote',
            'split_block',
            'tour_stop',
            'video',
            'vtour_embed'
        ])
    ])
@stop

@section('fieldsets')
    @component('admin.partials.featured-related', ['form_fields' => $form_fields, 'autoRelated' => $autoRelated])
        @slot('routePrefix', 'collection')
        @slot('moduleName', 'highlights')
    @endcomponent

    @include('admin.partials.meta')

@stop

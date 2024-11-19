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

    @include('twill.partials.hero')

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

    @include('twill.partials.authors')

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'hr', 'artwork', 'split_block', 'gallery_new', 'video', 'quote', 'tour_stop', 'media_embed', 'list', 'grid', 'button', 'audio_player', 'vtour_embed', 'event', 'feature_2x', 'layered_image_viewer', '3d_model', 'feature_4x'
        ])
    ])
@stop

@section('fieldsets')
    @component('twill.partials.featured-related', ['form_fields' => $form_fields, 'autoRelated' => $autoRelated])
        @slot('routePrefix', 'collection')
        @slot('moduleName', 'highlights')
    @endcomponent

    @include('twill.partials.meta')

@stop

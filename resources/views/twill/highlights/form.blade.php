@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related']
    ]
])

@section('contentFields')
    <x-twill::input
        name='title'
        label='Title'
        :required='true'
    />

    <x-twill::multi-select
        name='siteTags'
        label='Tags'
        placeholder='Select some tags'
        :options='$siteTagsList'
    />

    <x-twill::multi-select
        name='categories'
        label='Categories'
        placeholder='Select some categories'
        :options='$categoriesList'
    />

    <x-twill::input
        name='title_display'
        label='Title formatting (optional)'
        note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    />

    <x-twill::wysiwyg
        name='short_copy'
        label='Short intro copy'
        note='Max 255 characters'
        :maxlength='255'
        :toolbar-options="[ 'italic' ]"
    />

    @include('twill.partials.hero')

    <x-twill::select
        name='highlight_type'
        label='Type'
        placeholder='Select a type'
        :options='$highlightTypeList'
    />

    <x-twill::checkbox
        name='is_unlisted'
        label="Don't show this highlight in listings"
    />

    <x-twill::checkbox
        name='is_in_magazine'
        label='Assume this highlight is featured in a magazine issue'
    />

    @include('twill.partials.authors')

    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'hr', 'artwork', 'split_block', 'gallery_new', 'video', 'quote', 'tour_stop', 'media_embed', 'list', 'grid', 'button', 'audio_player', 'event', 'feature_2x', 'layered_image_viewer', '3d_model', 'feature_4x'
        ]);
    @endphp

    <x-twill::block-editor
        :blocks='$blocks'
    />
@stop

@section('fieldsets')
    @component('twill.partials.featured-related', ['form_fields' => $form_fields, 'autoRelated' => $autoRelated])
        @slot('routePrefix', 'collection')
        @slot('moduleName', 'highlights')
    @endcomponent

    @include('twill.partials.meta')

@stop

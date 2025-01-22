@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'content', 'label' => 'Content'],
        ['fieldset' => 'related_to', 'label' => 'Related'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
    ]
])

@section('contentFields')
    <x-twill::input
        name='title_display'
        label='Title formatting (optional)'
        note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    />

    <x-twill::input
        name='video_url'
        label='Video URL'
    />

    <x-twill::input
        name='duration'
        label='Duration'
        note='e.g. 3:45'
    />

    <x-twill::medias
        label='Hero Image'
        name='hero'
        note='Minimum image width 3000px'
    />

    <x-twill::date-picker
        name='date'
        label='Display date'
        note='When was this video published?'
    />

    <x-twill::checkbox
        name='is_listed'
        label='Show this video in listings'
    />

    <x-twill::wysiwyg
        name='list_description'
        label='List description'
        note='Max 255 characters. Will be used in "Related Videos" and social media.'
        :maxlength='255'
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::input
        name='heading'
        label='Heading'
        type='textarea'
        :rows='3'
    />

    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            'paragraph', 'hr', 'artwork', 'split_block', 'quote', 'tour_stop', 'list', 'button', 'audio_player', 'membership_banner', 'mobile_app', 'artworks'
        ]);
    @endphp

    <x-twill::block-editor
        :blocks='$blocks'
    />
@stop

@section('fieldsets')

    <a17-fieldset id="related_to" title="Related">

        <x-twill::multi-select
            name='categories'
            label='Categories'
            placeholder='Select some categories'
            :options="$categoriesList"
        />

        <p>If this is left blank, we will show the four most recently published videos.</p>

        <x-twill::browser
            name='related_videos'
            label='Related videos'
            route-prefix='collection.articlesPublications'
            module-name='videos'
            :max='4'
        />

    </a17-fieldset>

    <a17-fieldset id="metadata" title="Overwrite default metadata (optional)">
        <x-twill::input
            name='meta_title'
            label='Metadata Title'
        />

        <x-twill::input
            name='meta_description'
            label='Metadata Description'
            type='textarea'
        />

        <x-twill::input
            name='search_tags'
            label='Internal Search Tags'
            type'textarea'
        />

    <p>Comma-separatated list of words or phrases. Don't worry about grammar or similar word variations. This field is intended to assist our internal search engine in finding your content. These tags will not be shown to website users and will have no effect on external search engines, e.g. Google.</p>

    </a17-fieldset>

    @include('twill.partials.related')

@endsection

@extends('twill::layouts.form')
@section('contentFields')
    <x-twill::input
        name='intro'
        label='Introduction'
        type='textarea'
    />

    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            'custom_banner',
            'playlist_grid',
            'video_grid',
    ]);
    @endphp
    <x-twill::block-editor
        :blocks="$blocks"
    />

    <x-twill::formFieldset id="metadata" title="Overwrite default metadata (optional)">
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
            type='textarea'
        />
        <p>Comma-separated list of words or phrases. Don't worry about grammar or similar word variations. This field is intended to assist our internal search engine in finding your content. These tags will not be shown to website users and will have no effect on external search engines, e.g. Google.</p>
    </x-twill::formFieldset>
@stop

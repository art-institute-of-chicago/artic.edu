@extends('twill::layouts.form')
@section('contentFields')
    <x-twill::input
        name='intro'
        label='Introduction'
        type='textarea'
    />

    <x-twill::browser
        name='videos'
        label='Featured Videos'
        route-prefix='collection.articlesPublications'
        module-name='videos'
        :max='3'
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
@stop

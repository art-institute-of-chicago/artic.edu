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
@stop

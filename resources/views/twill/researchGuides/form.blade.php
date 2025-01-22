@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::medias
        label='Banner image'
        name='banner'
        note='Minimum image width 2000px'
    />

    <x-twill::medias
        label='Listing image'
        name='listing'
        note='Minimum image width 3000px'
    />

    <x-twill::input
        name='listing_description'
        label='Listing description'
        type='textarea'
        :maxlength='255'
    />

    <x-twill::input
        name='short_description'
        label='Short description'
        type='textarea'
        :maxlength='255'
    />

    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'hr', 'link', 'video', 'accordion', 'media_embed', 'list', 'timeline', 'newsletter_signup_inline', 'membership_banner', '3d_model'
        ]);
    @endphp

    <x-twill::block-editor
        :blocks='$blocks'
    />
@stop

@section('fieldsets')
    @include('twill.partials.meta')
@endsection

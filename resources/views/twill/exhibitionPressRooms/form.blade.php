@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='title_display'
        label='Title formatting (optional)'
        note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    />

    <x-twill::medias
        name='banner'
        label='Banner image'
        note='Minimum image width 2000px'
    />

    <x-twill::medias
        name='listing'
        label='Listing image'
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
            'paragraph', 'image', 'hr', 'split_block', 'link', 'video', 'accordion', 'media_embed', 'list', 'timeline', 'button', 'newsletter_signup_inline', 'membership_banner', '3d_model'
        ]);
    @endphp

    <x-twill::block-editor
        :blocks='$blocks'
    />
@stop

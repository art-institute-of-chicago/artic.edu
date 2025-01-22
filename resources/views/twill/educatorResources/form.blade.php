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

    <x-twill::wysiwyg
        name='listing_description'
        label='Listing description'
        note='Max 255 characters'
        :maxlength="255"
        :toolbar-options="[ 'italic' ]"
    />

    <x-twill::input
        name='short_description'
        label='Short description'
        type='textarea'
        :maxlength='255'
    />

    <x-twill::multi-select
        name='categories'
        label='Categories'
        placeholder='Select some categories'
        :options='$categoriesList'
    />

    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'hr', 'artwork', 'split_block', 'gallery_new', 'link', 'video', 'quote', 'tour_stop', 'accordion', 'media_embed', 'list', 'timeline', 'button', 'newsletter_signup_inline', 'audio_player', 'membership_banner', '3d_model', 'mobile_app', 'citiation'
        ]);
    @endphp

    <x-twill::block-editor
        :blocks='$blocks'
    />
@stop

@section('fieldsets')

    @include('twill.partials.related')

    @include('twill.partials.meta')

@endsection

@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='title_display'
        label='Title formatting (optional)'
        note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    />

    <x-twill::medias
        label='Banner image'
        name='banner'
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
        unpack='true'
        :options='$categoriesList'
    />

    @php
        $blocks = BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'hr', 'split_block', 'link', 'video', 'accordion', 'media_embed', 'list', 'timeline', 'newsletter_signup_inline', 'membership_banner', '3d_model'
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

@extends('twill::layouts.form')

@section('contentFields')
    <x-twill::input
        name='title_display'
        label='Title formatting (optional)'
        note='Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    />

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Banner image',
        'name' => 'banner',
        'note' => 'Minimum image width 2000px'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Listing image',
        'name' => 'listing',
        'note' => 'Minimum image width 3000px'
    ])

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

    <x-twill::checkbox
        name='is_unlisted'
        label="Don't show this press release in listings"
    />

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'hr', 'split_block', 'link', 'video', 'accordion', 'media_embed', 'list', 'timeline', 'newsletter_signup_inline', 'membership_banner', '3d_model'
        ])
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="sponsors" title="Sponsors">
        @formField('browser', [
            'routePrefix' => 'exhibitionsEvents',
            'moduleName' => 'sponsors',
            'name' => 'sponsors',
            'label' => 'Sponsors',
            'note' => 'Display content blocks from this sponsor',
            'max' => 1
        ])
    </a17-fieldset>

    @include('twill.partials.meta')
@endsection

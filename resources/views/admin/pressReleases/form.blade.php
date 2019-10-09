@extends('twill::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

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

    @formField('wysiwyg', [
        'name' => 'listing_description',
        'label' => 'Listing description',
        'maxlength'  => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('input', [
        'name' => 'short_description',
        'label' => 'Short description',
        'type' => 'textarea',
        'maxlength' => 255
    ])
    @formField('block_editor', [
        'blocks' => getBlocksForEditor([
            'paragraph', 'image', 'video', 'media_embed', 'list',
            'accordion', 'membership_banner', 'timeline', 'link', 'newsletter_signup_inline',
            'split_block', 'hr', '3d_model'
        ])
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="sponsors" title="Sponsors">
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'sponsors',
            'name' => 'sponsors',
            'label' => 'Sponsors',
            'note' => 'Display content blocks from this sponsor',
            'max' => 1
        ])
    </a17-fieldset>

    @include('admin.partials.meta')
@endsection

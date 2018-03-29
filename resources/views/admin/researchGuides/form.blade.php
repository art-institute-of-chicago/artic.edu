@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Banner image',
        'name' => 'banner'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Listing image',
        'name' => 'listing'
    ])

    @formField('input', [
        'name' => 'listing_description',
        'label' => 'Listing Description',
        'type' => 'textarea'
    ])

    @formField('input', [
        'name' => 'short_description',
        'label' => 'Short Description',
        'type' => 'textarea'
    ])
    @formField('block_editor', [
        'blocks' => [
            'paragraph', 'image', 'video', 'media_embed', 'list',
            'accordion', 'membership_banner', 'timeline', 'link', 'newsletter_signup_inline'
        ]
    ])
@stop


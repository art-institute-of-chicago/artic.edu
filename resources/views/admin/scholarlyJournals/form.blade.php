@extends('twill::layouts.form')

@section('contentFields')
    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Banner image',
        'name' => 'banner',
        'note' => 'Minimum image width 2000px'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'label' => 'Listing image',
        'name' => 'listing'
        'note' => 'Minimum image width 3000px'
    ])

    @formField('input', [
        'name' => 'listing_description',
        'label' => 'Listing description',
        'type' => 'textarea',
        'maxlength' => 255
    ])

    @formField('input', [
        'name' => 'short_description',
        'label' => 'Short description',
        'type' => 'textarea',
        'maxlength' => 255
    ])
    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            '3d_model',
            'accordion',
            'hr',
            'image',
            'link',
            'list',
            'media_embed',
            'membership_banner',
            'newsletter_signup_inline',
            'paragraph',
            'timeline',
            'video'
        ])
    ])
@stop

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
        'name' => 'listing',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('input', [
        'name' => 'listing_description',
        'label' => 'Listing Description',
        'type' => 'textarea',
        'maxlength' => 255
    ])

    @formField('input', [
        'name' => 'short_description',
        'label' => 'Short Description',
        'type' => 'textarea',
        'maxlength' => 255
    ])

    @formField('multi_select', [
        'name' => 'categories',
        'label' => 'Categories',
        'options' => $categoriesList,
        'placeholder' => 'Select some categories',
    ])

    @formField('block_editor', [
        'blocks' => [
            'paragraph', 'image', 'video', 'media_embed', 'list',
            'accordion', 'membership_banner', 'timeline', 'link', 'newsletter_signup_inline'
        ]
    ])
@stop

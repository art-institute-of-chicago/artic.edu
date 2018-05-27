@extends('cms-toolkit::layouts.form')

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
        'label' => 'Listing description',
        'type' => 'textarea',
        'maxlength'  => 255
    ])

    @formField('input', [
        'name' => 'short_description',
        'label' => 'Short description',
        'type' => 'textarea',
        'maxlength' => 255
    ])

    @formField('multi_select', [
        'name' => 'categories',
        'label' => 'Categories',
        'options' => $categoriesList,
        'placeholder' => 'Select some categories',
    ])

    @formField('input', [
        'name' => 'redirect_url',
        'label' => 'Redirect URL',
    ])

    @formField('checkbox', [
        'name'  => 'is_redirect_url_external',
        'label' => 'Is Redirect URL external?',
    ])

    @formField('block_editor', [
        'blocks' => [
            'paragraph', 'image', 'video', 'media_embed', 'list',
            'child_pages', 'accordion', 'membership_banner',
            'timeline', 'link', 'newsletter_signup_inline'
        ]
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="related" title="Related">
        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 1,
            'moduleName' => 'exhibitions',
            'name' => 'exhibitions',
            'label' => 'Related exhibitions'
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'events',
            'name' => 'events',
            'label' => 'Related events',
            'max' => 1
        ])

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'articles',
            'name' => 'articles',
            'label' => 'Related articles',
            'max' => 1
        ])

    </a17-fieldset>
@stop

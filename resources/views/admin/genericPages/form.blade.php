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

    @formField('wysiwyg', [
        'name' => 'short_description',
        'label' => 'Short description',
        'maxlength' => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic'
        ],
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

    @formField('checkbox', [
        'name'  => 'http_protected',
        'label' => 'Authentication required?',
    ])

    @formField('block_editor', [
        'blocks' => [
            'paragraph', 'image', 'video', 'media_embed', 'list',
            'child_pages', 'accordion', 'membership_banner',
            'timeline', 'link', 'newsletter_signup_inline',
            'artwork', 'artworks',
            'hr', 'split_block'
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

    <a17-fieldset id="metadata" title="Overwrite default metadata (optional)">
        @formField('input', [
            'name' => 'meta_title',
            'label' => 'Metadata Title'
        ])

        @formField('input', [
            'name' => 'meta_description',
            'label' => 'Metadata Description',
            'type' => 'textarea'
        ])
    </a17-fieldset>

@stop

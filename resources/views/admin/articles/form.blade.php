@extends('cms-toolkit::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'attributes', 'label' => 'Attributes'],
        ['fieldset' => 'related', 'label' => 'Related'],
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related']
    ]
])

@section('contentFields')
    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Display date',
    ])

    @formField('select', [
        'name' => 'layout_type',
        'label' => 'Article layout',
        'options' => $articleLayoutsList,
        'default' => '0'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero image',
        'name' => 'hero'
    ])

    @formField('multi_select', [
        'name' => 'categories',
        'label' => 'Categories',
        'options' => $categoriesList,
        'placeholder' => 'Select some categories',
    ])

    @formField('input', [
        'name' => 'type',
        'label' => 'Article Label'
    ])

    @formField('input', [
        'name' => 'heading',
        'label' => 'Header',
        'rows' => 3,
        'type' => 'textarea',
        'maxlength' => 255
    ])

    @formField('input', [
        'name' => 'author',
        'label' => 'Author'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Author thumbnail',
        'name' => 'author'
    ])

    @formField('checkbox', [
        'name' => 'is_boosted',
        'label' => 'Boost this article on search results'
    ])

    @formField('input', [
        'name' => 'citations',
        'label' => 'Citation',
        'rows' => 3,
        'type' => 'textarea'
    ])

    @formField('block_editor', [
        'blocks' => [
            'paragraph', 'image', 'video', 'gallery', 'media_embed', 'quote',
            'list', 'artwork', 'artworks', 'references', 'citation'
        ]
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="related" title="Related">

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'name' => 'articles',
            'moduleName' => 'articles',
            'max' => 1,
            'label' => 'Related articles',
        ])

        @formField('browser', [
            'routePrefix' => 'collection',
            'name' => 'selections',
            'moduleName' => 'selections',
            'max' => 1,
            'label' => 'Related selections',
        ])

        @formField('browser', [
            'routePrefix' => 'collection',
            'name' => 'artworks',
            'moduleName' => 'artworks',
            'label' => 'Related artwork',
            'max' => 500
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'name' => 'exhibitions',
            'moduleName' => 'exhibitions',
            'max' => 1,
            'label' => 'Related exhibitions',
        ])

    </a17-fieldset>

    <a17-fieldset id="side_related" title="Sidebar Related - Only one will show up randomly">
        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'videos',
            'max' => 1,
            'name' => 'videos',
            'label' => 'Related video'
        ])

        @formField('browser', [
            'routePrefix' => 'collection.articles_publications',
            'moduleName' => 'articles',
            'max' => 1,
            'name' => 'sidebarArticle',
            'label' => 'Related article',
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'max' => 1,
            'name' => 'sidebarExhibitions',
            'label' => 'Related Exhibition',
            'moduleName' => 'exhibitions',
        ])

        @formField('browser', [
            'routePrefix' => 'exhibitions_events',
            'moduleName' => 'events',
            'name' => 'sidebarEvent',
            'label' => 'Related event',
            'max' => 1
        ])
    </a17-fieldset>
@endsection

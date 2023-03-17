@section('contentFields')
    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 5,
        'moduleName' => 'articles',
        'name' => 'featured_items',
        'endpoints' => [
            [
                'label' => 'Article',
                'value' => '/collection/articles_publications/articles/browser'
            ],
            [
                'label' => 'Interactive feature',
                'value' => moduleRoute('experiences', 'collection.interactive_features', 'browser')
            ]
        ],
        'label' => 'Featured items',
    ])

    @formField('browser', [
        'routePrefix' => 'collection.interactive_features',
        'max' => 4,
        'moduleName' => 'experiences',
        'name' => 'experiences',
        'label' => 'Interactive Features'
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 3,
        'moduleName' => 'digitalPublications',
        'name' => 'digitalPublications',
        'label' => 'Digital Publications'
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 4,
        'moduleName' => 'printedPublications',
        'name' => 'printedPublications',
        'label' => 'Print Publications'
    ])

    @formField('input', [
        'type' => 'textarea',
        'name' => 'printed_publications_intro',
        'label' => 'Print Publications intro text',
    ])
@stop

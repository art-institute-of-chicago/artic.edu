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
                'label' => 'Digital label',
                'value' => '/collection/digitalLabels/browser'
            ]
        ],
        'label' => 'Featured items',
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 4,
        'moduleName' => 'digitalLabels',
        'name' => 'digitalLabels',
        'label' => 'Digital Labels'
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

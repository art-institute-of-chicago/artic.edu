@section('contentFields')
    @formField('input', [
        'name' => 'art_intro',
        'label' => 'Intro text',
    ])

    @formField('browser', [
        'routePrefix' => 'collection',
        'max' => 25,
        'moduleName' => 'categoryTerms',
        'name' => 'artCategoryTerms',
        'label' => 'Quick filters'
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articlesPublications',
        'max' => 5,
        'moduleName' => 'articles',
        'name' => 'featured_items',
        'endpoints' => [
            [
                'label' => 'Article',
                'value' => '/collection/articlesPublications/articles/browser'
            ],
            [
                'label' => 'Interactive feature',
                'value' => moduleRoute('experiences', 'collection.interactiveFeatures', 'browser')
            ]
        ],
        'label' => 'Featured items',
    ])

@stop

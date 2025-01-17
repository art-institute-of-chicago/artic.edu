@section('contentFields')
    @formField('browser', [
        'routePrefix' => 'collection.articlesPublications',
        'max' => 3,
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

    @formField('browser', [
        'routePrefix' => 'collection.articlesPublications',
        'max' => 10,
        'moduleName' => 'categories',
        'name' => 'articlesCategories',
        'label' => 'Categories'
    ])
@stop

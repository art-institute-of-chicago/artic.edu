@section('contentFields')
    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 3,
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
    {{-- @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 3,
        'moduleName' => 'articles',
        'name' => 'articlesArticles',
        'label' => 'Featured articles'
    ]) --}}

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 10,
        'moduleName' => 'categories',
        'name' => 'articlesCategories',
        'label' => 'Categories'
    ])
@stop

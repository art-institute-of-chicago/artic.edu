@section('contentFields')
    @formField('input', [
        'name' => 'art_intro',
        'label' => 'Intro text',
    ])

    @formField('browser', [
        'routePrefix' => 'collection',
        'max' => 10,
        'moduleName' => 'categoryTerms',
        'name' => 'artCategoryTerms',
        'label' => 'Category Terms'
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 5,
        'moduleName' => 'articles',
        'name' => 'artArticles',
        'label' => 'Featured articles'
    ])
@stop

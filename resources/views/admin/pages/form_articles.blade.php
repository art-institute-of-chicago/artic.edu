@section('contentFields')
    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 3,
        'moduleName' => 'articles',
        'name' => 'articlesArticles',
        'label' => 'Featured articles'
    ])
@stop

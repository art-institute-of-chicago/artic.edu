@section('contentFields')
    @formField('browser', [
        'routePrefix' => 'whatson',
        'max' => 3,
        'moduleName' => 'articles',
        'name' => 'articlesArticles',
        'label' => 'Featured articles'
    ])
@stop

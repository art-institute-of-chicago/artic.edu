@section('contentFields')
    @formField('input', [
        'name' => 'art_intro',
        'label' => 'Intro text',
    ])

    @formField('browser', [
        'routePrefix' => 'whatson',
        'max' => 5,
        'moduleName' => 'articles',
        'name' => 'artArticles',
        'label' => 'Featured Articles'
    ])
@stop

@section('contentFields')

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 5,
        'moduleName' => 'articles',
        'name' => 'articles',
        'label' => 'Featured articles'
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 3,
        'moduleName' => 'printedCatalogs',
        'name' => 'printedCatalogs',
        'label' => 'Printed catalogs'
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 3,
        'moduleName' => 'digitalCatalogs',
        'name' => 'digitalCatalogs',
        'label' => 'Digital catalogs'
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 3,
        'moduleName' => 'scholarlyJournals',
        'name' => 'scholarlyJournals',
        'label' => 'Scholarly journals'
    ])
@stop

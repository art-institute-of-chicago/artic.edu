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
        'moduleName' => 'digitalCatalogs',
        'name' => 'digitalCatalogs',
        'label' => 'Digital catalogues'
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 4,
        'moduleName' => 'printedCatalogs',
        'name' => 'printedCatalogs',
        'label' => 'Printed catalogues'
    ])

    @formField('input', [
        'type' => 'textarea',
        'name' => 'printed_catalogs_intro',
        'label' => 'Printed Catalogs intro text',
    ])
@stop

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
        'moduleName' => 'digitalPublications',
        'name' => 'digitalPublications',
        'label' => 'Digital Publications'
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 4,
        'moduleName' => 'printedCatalogs',
        'name' => 'printedCatalogs',
        'label' => 'Print Catalogues'
    ])

    @formField('input', [
        'type' => 'textarea',
        'name' => 'printed_catalogs_intro',
        'label' => 'Print Catalogues intro text',
    ])
@stop

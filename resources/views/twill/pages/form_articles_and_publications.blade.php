@section('contentFields')
    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 6,
        'moduleName' => 'digitalPublications',
        'name' => 'digitalPublications',
        'label' => 'Digital Publications'
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articles_publications',
        'max' => 6,
        'moduleName' => 'printedPublications',
        'name' => 'printedPublications',
        'label' => 'Print Publications'
    ])

    @formField('input', [
        'type' => 'textarea',
        'name' => 'printed_publications_intro',
        'label' => 'Print Publications intro text',
    ])
@stop

@section('contentFields')
    @formField('browser', [
        'routePrefix' => 'collection.articlesPublications',
        'max' => 6,
        'moduleName' => 'digitalPublications',
        'name' => 'digitalPublications',
        'label' => 'Digital Publications'
    ])

    @formField('browser', [
        'routePrefix' => 'collection.articlesPublications',
        'max' => 6,
        'moduleName' => 'printedPublications',
        'name' => 'printedPublications',
        'label' => 'Print Publications'
    ])

    <x-twill::input
        type='textarea'
        name='printed_publications_intro'
        label='Print Publications intro text'
    />
@stop

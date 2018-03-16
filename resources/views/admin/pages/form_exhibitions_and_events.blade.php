@section('contentFields')
    @formField('input', [
        'name' => 'exhibition_intro',
        'label' => 'Intro text',
    ])

    @formField('browser', [
        'routePrefix' => 'exhibitions_events',
        'max' => 2,
        'moduleName' => 'exhibitions',
        'name' => 'exhibitionsExhibitions',
        'label' => 'Featured exhibitions'
    ])

    @formField('browser', [
        'routePrefix' => 'exhibitions_events',
        'max' => 20,
        'moduleName' => 'exhibitions',
        'name' => 'exhibitionsCurrent',
        'label' => 'Listing exhibitions'
    ])
@stop

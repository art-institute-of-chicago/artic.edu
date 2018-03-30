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
        'max' => 2,
        'moduleName' => 'exhibitions',
        'name' => 'exhibitionsUpcoming',
        'label' => 'Featured exhibitinos - Upcoming listing'
    ])

    @formField('browser', [
        'routePrefix' => 'exhibitions_events',
        'max' => 12,
        'moduleName' => 'exhibitions',
        'name' => 'exhibitionsCurrent',
        'label' => 'Listing exhibitions'
    ])
@stop

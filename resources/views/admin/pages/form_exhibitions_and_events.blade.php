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
        'label' => 'Featured exhibitions - current'
    ])

    @formField('browser', [
        'routePrefix' => 'exhibitions_events',
        'max' => 2,
        'moduleName' => 'exhibitions',
        'name' => 'exhibitionsUpcoming',
        'label' => 'Featured exhibitions - upcoming'
    ])

    @formField('browser', [
        'routePrefix' => 'exhibitions_events',
        'max' => 12,
        'moduleName' => 'exhibitions',
        'name' => 'exhibitionsCurrent',
        'label' => 'Secondary features - current'
    ])
@stop

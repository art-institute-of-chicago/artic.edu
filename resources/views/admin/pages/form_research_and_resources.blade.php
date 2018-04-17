@section('contentFields')
    @formField('browser', [
    'routePrefix' => 'generic',
        'max' => 7,
        'moduleName' => 'genericPages',
        'name' => 'researchResourcesFeaturePages',
        'label' => 'Featured pages'
    ])

    @formField('browser', [
    'routePrefix' => 'generic',
        'max' => 3,
        'moduleName' => 'genericPages',
        'name' => 'researchResourcesStudyRooms',
        'label' => 'Study room pages'
    ])

    @formField('browser', [
    'routePrefix' => 'generic',
        'max' => 1,
        'moduleName' => 'genericPages',
        'name' => 'researchResourcesStudyRoomMore',
        'label' => 'Study room more link'
    ])
@stop

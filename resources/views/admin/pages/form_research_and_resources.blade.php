@section('contentFields')
    @formField('input', [
        'name' => 'resources_landing_title',
        'label' => 'Title',
    ])

    @formField('input', [
        'name' => 'resources_landing_intro',
        'label' => 'Intro text',
        'type' => 'textarea'
    ])

    @formField('medias', [
        'label' => 'Hero image',
        'name' => 'research_landing_image'
    ])

    @formField('browser', [
    'routePrefix' => 'generic',
        'max' => 6,
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

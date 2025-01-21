@section('contentFields')
    <x-twill::input
        name='resources_landing_title'
        label='Title'
    />

    <x-twill::input
        name='resources_landing_intro'
        label='Intro text'
        type='textarea'
    />

    <x-twill::medias
        label='Hero image'
        name='research_landing_image'
    />

    @formField('browser', [
    'routePrefix' => 'generic',
        'max' => 9,
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

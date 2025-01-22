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

    <x-twill::browser
        name='researchResourcesFeaturePages'
        label='Featured pages'
        route-prefix='generic'
        module-name='genericPages'
        :max='9'
    />

    <x-twill::browser
        name='researchResourcesStudyRooms'
        label='Study room pages'
        route-prefix='generic'
        module-name='genericPages'
        :max='3'
    />

    <x-twill::browser
        name='researchResourcesStudyRoomMore'
        label='Study room more link'
        route-prefix='generic'
        module-name='genericPages'
        :max='1'
    />
@stop

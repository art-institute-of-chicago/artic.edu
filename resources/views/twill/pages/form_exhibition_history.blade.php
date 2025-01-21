@section('contentFields')
    <x-twill::input
        name='exhibition_history_sub_heading'
        label='Intro text'
    />

    <x-twill::medias
        name='exhibition_history_intro'
        label='Hero image'
    />

    <x-twill::input
        type='textarea'
        name='exhibition_history_intro_copy'
        label='Hero text'
    />
@stop

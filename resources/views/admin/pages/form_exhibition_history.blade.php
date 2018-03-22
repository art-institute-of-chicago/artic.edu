@section('contentFields')
    @formField('input', [
        'name' => 'exhibition_history_sub_heading',
        'label' => 'Sub heading',
    ])

    @formField('input', [
        'type' => 'textarea',
        'name' => 'exhibition_history_intro_copy',
        'label' => 'Intro text',
    ])

    @formField('input', [
        'type' => 'textarea',
        'name' => 'exhibition_history_popup_copy',
        'label' => 'Popup text',
    ])

    @formField('medias', [
        'name' => 'exhibition_history_intro',
        'label' => 'Intro image',
    ])
@stop

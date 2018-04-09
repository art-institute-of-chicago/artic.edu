@section('contentFields')
    @formField('input', [
        'name' => 'exhibition_history_sub_heading',
        'label' => 'Intro text',
    ])

    @formField('medias', [
        'name' => 'exhibition_history_intro',
        'label' => 'Hero image',
    ])

    @formField('input', [
        'type' => 'textarea',
        'name' => 'exhibition_history_intro_copy',
        'label' => 'Hero text',
    ])

{{--     @formField('input', [
        'type' => 'textarea',
        'name' => 'exhibition_history_popup_copy',
        'label' => 'Popup text',
    ])
 --}}
@stop

@formField('input', [
    'name' => 'exhibition_history_sub_heading',
    'label' => 'Sub Heading',
])

@formField('input', [
    'type' => 'textarea',
    'name' => 'exhibition_history_intro_copy',
    'label' => 'Intro Text',
])

@formField('input', [
    'type' => 'textarea',
    'name' => 'exhibition_history_popup_copy',
    'label' => 'Popup Text',
])

@formField('medias', [
    'name' => 'exhibition_history_intro',
    'label' => 'Intro Image',
    'with_multiple' => false,
    'no_crop' => false
])

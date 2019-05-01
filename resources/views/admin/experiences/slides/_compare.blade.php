@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'module_type',
    'fieldValues' => 'compare',
    'keepAlive' => true,
])
    @formField('input', [
        'name' => 'compare_title',
        'label' => 'Title'
    ])

    @formField('repeater', ['type' => 'compare_experience_image_1'])
    @formField('repeater', ['type' => 'compare_experience_image_2'])
    @formField('repeater', ['type' => 'compare_experience_modal'])
@endcomponent
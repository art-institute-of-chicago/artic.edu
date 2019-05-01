@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'module_type',
    'fieldValues' => 'interstitial',
    'keepAlive' => true,
])
    @formField('input', [
        'name' => 'interstitial_headline',
        'label' => 'Headline'
    ])

    @formField('input', [
        'name' => 'body_copy',
        'label' => 'Body Copy'
    ])

    @formField('input', [
        'name' => 'section_title',
        'label' => 'Section Title'
    ])

    @formField('repeater', ['type' => 'experience_image'])
@endcomponent
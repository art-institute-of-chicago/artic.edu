@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'module_type',
    'fieldValues' => 'interstitial',
    'keepAlive' => true,
])
    @formField('input', [
        'name' => 'section_title',
        'label' => 'Section Title',
        'maxlength' => 150,
    ])

    @formField('input', [
        'name' => 'interstitial_headline',
        'label' => 'Headline',
        'maxlength' => 150,
    ])

    @formField('input', [
        'name' => 'body_copy',
        'label' => 'Body Copy',
        'maxlength' => 150,
    ])

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'asset_type',
        'fieldValues' => 'standard',
        'keepAlive' => true,
    ])
        @formField('repeater', ['type' => 'experience_image'])
    @endcomponent
@endcomponent
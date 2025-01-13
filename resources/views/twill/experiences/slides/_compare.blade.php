@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'module_type',
    'fieldValues' => 'compare',
    'keepAlive' => true,
])
    @formField('wysiwyg', [
        'name' => 'compare_title',
        'label' => 'Primary Copy',
        'maxlength' => 500,
    ])

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'asset_type',
        'fieldValues' => 'standard',
        'keepAlive' => true,
    ])
        @formField('repeater', ['type' => 'compare_experience_image_1'])
    @endcomponent
    @formField('repeater', ['type' => 'compare_experience_image_2'])

    @formField('repeater', ['type' => 'compare_experience_modal'])
@endcomponent

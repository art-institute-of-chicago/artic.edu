@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'module_type',
    'fieldValues' => 'fullwidthmedia',
    'keepAlive' => true,
])
    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'asset_type',
        'fieldValues' => 'standard',
        'keepAlive' => true,
    ])
        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'fullwidthmedia_standard_media_type',
            'fieldValues' => 'type_image',
            'keepAlive' => true,
        ])
            @formField('repeater', ['type' => 'experience_image'])
        @endcomponent
    @endcomponent
    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'fullwidthmedia_standard_media_type',
        'fieldValues' => 'type_image',
        'keepAlive' => true,
    ])
        @formField('repeater', ['type' => 'experience_modal'])
    @endcomponent
    @formField('wysiwyg', [
        'name' => 'caption',
        'label' => 'Caption',
        'maxlength' => 500,
    ])
    @formField('checkbox', [
        'name' => 'fullwidth_inset',
        'label' => 'Inset',
    ])
@endcomponent
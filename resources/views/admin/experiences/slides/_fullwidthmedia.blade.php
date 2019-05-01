@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'module_type',
    'fieldValues' => 'fullwidthmedia',
    'keepAlive' => true,
])
    @formField('repeater', ['type' => 'experience_image'])
    @formField('repeater', ['type' => 'experience_modal'])
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
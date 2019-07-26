@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'module_type',
    'fieldValues' => 'interstitial',
    'keepAlive' => true,
])
    @formField('wysiwyg', [
        'name' => 'section_title',
        'label' => 'Section Title',
        'maxlength' => 150,
    ])

    @formField('wysiwyg', [
        'name' => 'interstitial_headline',
        'label' => 'Headline',
        'maxlength' => 150,
    ])

    @formField('wysiwyg', [
        'name' => 'body_copy',
        'label' => 'Body Copy',
        'maxlength' => 250,
    ])

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'asset_type',
        'fieldValues' => 'standard',
        'keepAlive' => true,
    ])
        @formField('repeater', ['type' => 'interstitial_experience_image'])
    @endcomponent
@endcomponent
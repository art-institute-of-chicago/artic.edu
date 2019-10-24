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
            @formField('repeater', ['type' => 'fullwidthmedia_experience_image'])
        @endcomponent
    @endcomponent
    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'fullwidthmedia_standard_media_type',
        'fieldValues' => 'type_image',
        'keepAlive' => true,
    ])
        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'asset_type',
            'fieldValues' => '3dModel',
            'isEqual' => false
        ])
            @formField('repeater', ['type' => 'experience_modal'])
        @endcomponent
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'asset_type',
        'fieldValues' => '3dModel',
        'keepAlive' => true
    ])
        <br />
        <a17-fieldset title="3D Object" id="3dModel">
            <a17-block-aic_3d_model name="aic_3d_model" :thumbnail="false" :caption="true" :browser="false"/>
        </a17-fieldset>
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
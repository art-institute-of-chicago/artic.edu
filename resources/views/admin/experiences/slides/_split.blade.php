@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'module_type',
    'fieldValues' => 'split',
    'keepAlive' => true,
])
    <div style="display: none" id="headline">
        @formField('input', [
            'name' => 'headline',
            'label' => 'Headline'
        ])
    </div>

    @formField('wysiwyg', [
        'name' => 'split_primary_copy',
        'label' => 'Primary Copy',
    ])

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'asset_type',
        'fieldValues' => 'standard',
        'keepAlive' => true,
    ])
        @component('twill::partials.form.utils._connected_fields', [
            'fieldName' => 'split_stiandard_media_type',
            'fieldValues' => 'type_image',
            'keepAlive' => true,
        ])
            @formField('repeater', ['type' => 'slide_primary_experience_image'])
        @endcomponent
    @endcomponent
        
    @formField('radios', [
        'name' => 'image_side',
        'label' => 'Primary Copy Side',
        'default' => 'left',
        'inline' => true,
        // The value and label not matched because on FE, it's controlling the image's side, but client want to rename the label to primary copy side
        'options' => [
            [
                'value' => 'right',
                'label' => 'Left'
            ],
            [
                'value' => 'left',
                'label' => 'Right'
            ],
        ]
    ])

    <div style="display: none" id="secondary_image">
        @formField('repeater', ['type' => 'slide_secondary_experience_image'])
    </div>

    <div style="display: none" id="primary_modal">
        @formField('repeater', ['type' => 'primary_experience_modal'])
    </div>
    <div style="display: none" id="secondary_modal">
        @formField('repeater', ['type' => 'secondary_experience_modal'])
    </div>
@endcomponent
@formField('medias', [
    'name' => 'experience_image',
    'label' => 'Image',
])

@formField('radios', [
    'name' => 'inline_credits',
    'label' => 'Inline Credits',
    'default' => 'off',
    'inline' => true,
    'options' => [
        [
            'value' => 'on',
            'label' => 'On'
        ],
        [
            'value' => 'off',
            'label' => 'Off'
        ]
    ]
])

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'inline_credits',
        'fieldValues' => 'on',
        'keepAlive' => true,
        'renderForBlocks' => true
])
    @formField('radios', [
        'name' => 'credits_input',
        'label' => 'Credits Input',
        'default' => 'datahub',
        'inline' => true,
        'options' => [
            [
                'value' => 'datahub',
                'label' => 'Datahub'
            ],
            [
                'value' => 'manual',
                'label' => 'Manual'
            ]
        ]
    ])
    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'credits_input',
        'fieldValues' => 'datahub',
        'renderForBlocks' => true,
        'keepAlive' => true,
    ])
        @formField('input', [
            'name' => 'object_id',
            'label' => 'Object ID'
        ])
    @endcomponent

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'credits_input',
        'fieldValues' => 'manual',
        'renderForBlocks' => true,
        'keepAlive' => true,
    ])
        @formField('input', [
            'name' => 'artist',
            'label' => 'Artist'
        ])
        @formField('input', [
            'name' => 'credit_title',
            'label' => 'Title'
        ])
        @formField('input', [
            'name' => 'credit_date',
            'label' => 'Date'
        ])
        @formField('input', [
            'name' => 'medium',
            'label' => 'Medium'
        ])
        @formField('input', [
            'name' => 'dimensions',
            'label' => 'Dimensions'
        ])
        @formField('input', [
            'name' => 'credit_line',
            'label' => 'Credit Line'
        ])
        @formField('input', [
            'name' => 'main_reference_number',
            'label' => 'Main Reference Number'
        ])
        @formField('input', [
            'name' => 'copyright_notice',
            'label' => 'Copyright Notice'
        ])
    @endcomponent
@endcomponent
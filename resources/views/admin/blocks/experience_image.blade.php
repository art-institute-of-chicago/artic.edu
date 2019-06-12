@formField('medias', [
    'name' => 'experience_image',
    'label' => 'Image',
])

@yield('caption')

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
        'maxlength' => 150,
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
            'label' => 'Object ID',
            'maxlength' => 150,
        ])
    @endcomponent

    @formField('input', [
        'name' => 'artist',
        'label' => 'Artist',
        'maxlength' => 150,
    ])
    @formField('input', [
        'name' => 'credit_title',
        'label' => 'Title',
        'maxlength' => 150,
    ])
    @formField('input', [
        'name' => 'credit_date',
        'label' => 'Date',
        'maxlength' => 150,
    ])
    @formField('input', [
        'name' => 'medium',
        'label' => 'Medium',
        'maxlength' => 150,
    ])
    @formField('input', [
        'name' => 'dimensions',
        'label' => 'Dimensions',
        'maxlength' => 150,
    ])
    @formField('input', [
        'name' => 'credit_line',
        'label' => 'Credit Line',
        'maxlength' => 150,
    ])
    @formField('input', [
        'name' => 'main_reference_number',
        'label' => 'Main Reference Number',
        'maxlength' => 150,
    ])
    @formField('input', [
        'name' => 'copyright_notice',
        'label' => 'Copyright Notice',
        'maxlength' => 150,
    ])

@endcomponent
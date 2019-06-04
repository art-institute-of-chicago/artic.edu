@unless($item->module_type === 'attract' || $item->module_type === 'end')
@formField('select', [
    'name' => 'module_type',
    'required' => true,
    'label' => 'Module Type',
    'placeholder' => 'Select a type',
    'options' => [
        [
            'value' => 'split',
            'label' => 'Split'
        ],
        [
            'value' => 'interstitial',
            'label' => 'Interstitial'
        ],
        [
            'value' => 'tooltip',
            'label' => 'Tooltip'
        ],
        [
            'value' => 'fullwidthmedia',
            'label' => 'Full-Width Media'
        ],
        [
            'value' => 'compare',
            'label' => 'Compare'
        ],
    ]
])
@endunless

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'module_type',
    'fieldValues' => 'split',
    'keepAlive' => true,
])
    @formField('multi_select', [
        'name' => 'split_attributes',
        'label' => 'Attributes',
        'options' => [
            [
                'value' => 'inset',
                'label' => 'Inset'
            ],
            [
                'value' => 'primary_modal',
                'label' => 'Primary Modal'
            ],
            [
                'value' => 'headline',
                'label' => 'Headline'
            ],
            [
                'value' => 'secondary_image',
                'label' => 'Secondary Image'
            ],
            [
                'value' => 'secondary_modal',
                'label' => 'Secondary Modal'
            ]
        ]
    ])
@endcomponent
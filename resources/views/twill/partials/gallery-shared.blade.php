@formField('select', [
    'name' => 'layout',
    'label' => 'Layout',
    'placeholder' => 'Select layout',
    'options' => [
        [
            'value' => 1,
            'label' => 'Layout 1 (Mosaic)'
        ],
        [
            'value' => 2,
            'label' => 'Layout 2 (Carousel)'
        ],
        [
            'value' => 3,
            'label' => 'Layout 3 (Small mosaic)'
        ]
    ]
])

@formField('select', [
    'name' => 'theme',
    'label' => 'Theme',
    'placeholder' => 'Select theme',
    'default' => 1,
    'options' => [
        [
            'value' => 1,
            'label' => 'Dark'
        ],
        [
            'value' => 2,
            'label' => 'Light'
        ],
        [
            'value' => 3,
            'label' => 'White'
        ]
    ]
])

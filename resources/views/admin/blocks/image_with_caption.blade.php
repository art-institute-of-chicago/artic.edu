@formField('select', [
    'name' => 'layout',
    'label' => 'Layout',
    'placeholder' => 'Select layout',
    'default' => 1,
    'options' => [
        [
            'value' => 1,
            'label' => 'Caption at the bottom'
        ],
        [
            'value' => 2,
            'label' => 'Caption at the left'
        ]
    ]
])

@formField('medias', [
    'name' => 'image',
    'label' => 'Image'
])

@formField('input', [
    'name' => 'caption',
    'label' => 'Caption'
])


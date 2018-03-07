{{-- @formField('select', [
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
]) --}}

@formField('select', [
    'name' => 'size',
    'label' => 'Size',
    'placeholder' => 'Select size',
    'default' => 'm',
    'options' => [
        [
            'value' => 's',
            'label' => 'Small'
        ],
        [
            'value' => 'm',
            'label' => 'Medium'
        ],
        [
            'value' => 'l',
            'label' => 'Large'
        ]
    ]
])

@formField('medias', [
    'name' => 'image',
    'label' => 'Thumbnail image'
])

@formField('input', [
    'name' => 'url',
    'label' => 'Video URL'
])

@formField('input', [
    'name' => 'caption_title',
    'label' => 'Caption Title'
])


@formField('input', [
    'type' => 'textarea',
    'name' => 'caption',
    'label' => 'Caption'
])


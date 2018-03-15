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


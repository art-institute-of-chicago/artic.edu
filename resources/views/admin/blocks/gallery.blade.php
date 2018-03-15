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
        ]
    ]
])

@formField('input', [
    'name' => 'title',
    'label' => 'Title',
    'maxlength' => 150
])

@formField('input', [
    'type' => 'textarea',
    'name' => 'description',
    'label' => 'Description',
    'rows' => 4
])

@formField('repeater', ['type' => 'gallery_item'])

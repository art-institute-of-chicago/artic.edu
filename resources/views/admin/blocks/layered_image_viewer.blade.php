@twillBlockTitle('Layered Image Viewer')
@twillBlockIcon('image')

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

@formField('checkbox', [
    'name' => 'disable_image_modals',
    'label' => 'Disable modals for these images',
])

@formField('repeater', ['type' => 'layered_viewer_image'])
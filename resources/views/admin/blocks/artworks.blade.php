@formField('browser', [
    'routePrefix' => 'whatson',
    'name' => 'artworks',
    'moduleName' => 'artworks',
    'label' => 'Artworks',
    'max' => 100
])

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
    'type' => 'textarea',
    'name' => 'description',
    'label' => 'Description',
    'rows' => 4
])

@formField('input', [
    'name' => 'subhead',
    'label' => 'Image Subhead',
    'maxlength' => 150
])

@formField('input', [
    'name' => 'label',
    'label' => 'Image Label',
    'maxlength' => 150
])

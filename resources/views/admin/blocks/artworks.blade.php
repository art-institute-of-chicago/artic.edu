@formField('browser', [
    'routePrefix' => 'collection',
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
    'name' => 'title',
    'label' => 'Gallery Title',
    'maxlength' => 150
])

@formField('input', [
    'name' => 'subhead',
    'label' => 'Image Subhead'
])


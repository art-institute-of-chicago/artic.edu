@formField('radios', [
    'name' => 'variation',
    'label' => 'Variation',
    'default' => 'quarter',
    'inline' => true,
    'options' => [
        [
            'value' => 'quarter',
            'label' => 'Quarter block'
        ],
        [
            'value' => 'half',
            'label' => 'Half block'
        ],
    ]
])

@formField('medias', [
    'name' => 'image',
    'label' => 'Image',
    'max' => 1
])

@include('admin.blocks.paragraph')

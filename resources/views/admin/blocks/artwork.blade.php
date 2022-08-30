@twillBlockTitle('Artwork')
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

<p>Note: if the chosen artwork does not have rights to be viewed at a large size, it will display as size small</p>

@formField('browser', [
    'routePrefix' => 'collection',
    'name' => 'artworks',
    'moduleName' => 'artworks',
    'label' => 'Artworks',
    'max' => 1
])

@formField('wysiwyg', [
    'name' => 'captionAddendum',
    'label' => 'Caption addendum',
    'note' => 'Appended to generated tombstone',
    'toolbarOptions' => [
        'italic', 'link',
    ],
])

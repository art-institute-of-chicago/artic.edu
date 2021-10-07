@twillBlockTitle('Feature 4x')
@twillBlockIcon('image')

@formField('browser', [
    'routePrefix' => 'collection',
    'moduleName' => 'highlights',
    'name' => 'highlights',
    'endpoints' => [
        [
            'label' => 'Highlights',
            'value' => moduleRoute('highlights', 'collection', 'browser', [], false)
        ]
    ],
    'max' => 4,
    'label' => 'Featured items',
])

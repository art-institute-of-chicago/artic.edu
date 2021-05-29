@twillBlockTitle('Feature 4x')
@twillBlockIcon('image')
@twillBlockComponent('a17-block-feature_4x')

@formField('browser', [
    'routePrefix' => 'collection',
    'moduleName' => 'selections',
    'name' => 'selections',
    'endpoints' => [
        [
            'label' => 'Highlights',
            'value' => moduleRoute('selections', 'collection', 'browser', [], false)
        ]
    ],
    'max' => 4,
    'label' => 'Featured items',
])

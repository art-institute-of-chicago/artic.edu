@twillBlockTitle('Feature 2x')
@twillBlockIcon('image')

@formField('browser', [
    'routePrefix' => 'collection.interactive_features',
    'moduleName' => 'experiences',
    'name' => 'experiences',
    'endpoints' => [
        [
            'label' => 'Interactive feature',
            'value' => moduleRoute('experiences', 'collection.interactive_features', 'browser', [], false)
        ]
    ],
    'max' => 2,
    'label' => 'Featured items',
])

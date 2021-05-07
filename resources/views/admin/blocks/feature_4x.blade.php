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

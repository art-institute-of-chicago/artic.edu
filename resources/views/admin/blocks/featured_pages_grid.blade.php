@twillBlockTitle('Featured Pages Grid')
@twillBlockIcon('image')

@formField('input', [
    'name' => 'grid_heading',
    'label' => 'Heading',
])

@formField('browser', [
    'routePrefix' => 'generic',
    'moduleName' => 'genericPages',
    'name' => 'genericPages',
    'endpoints' => [
        [
            'label' => 'Generic Pages',
            'value' => moduleRoute('genericPages', 'generic', 'browser', [], false)
        ],
        [
            'label' => 'Landing Pages',
            'value' => moduleRoute('landingPages', 'generic', 'browser', [], false)
        ]
    ],
    'max' => 12,
    'label' => 'Featured Pages',
])
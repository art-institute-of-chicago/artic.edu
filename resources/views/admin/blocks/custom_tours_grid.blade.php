@twillBlockTitle('Custom Tours Grid')
@twillBlockIcon('image')

@formField('input', [
    'name' => 'custom_tours_grid_heading',
    'label' => 'Heading',
])

@formField('browser', [
    'routePrefix' => 'visit',
    'moduleName' => 'customToursItems',
    'name' => 'customToursItems',
    'label' => 'Custom Tours',
    'max' => -1,
])

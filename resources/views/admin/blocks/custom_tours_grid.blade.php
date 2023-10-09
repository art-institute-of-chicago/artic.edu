@twillBlockTitle('Custom Tours Grid')
@twillBlockIcon('image')

@formField('wysiwyg', [
    'name' => 'custom_tours_grid_heading',
    'label' => 'Heading',
    'toolbarOptions' => [
    'italic'
    ],
])

@formField('browser', [
    'routePrefix' => 'visit',
    'moduleName' => 'customToursItems',
    'name' => 'customToursItems',
    'label' => 'Custom Tours',
    'max' => -1,
])

@twillBlockTitle('Custom Tours Grid')
@twillBlockIcon('image')

@formField('wysiwyg', [
    'name' => 'custom_tours_grid_heading',
    'label' => 'Heading',
    'toolbarOptions' => [
        'italic'
    ],
])

@formField('wysiwyg', [
    'name' => 'custom_tours_grid_text',
    'label' => 'Intro Text',
    'toolbarOptions' => [
        'italic'
    ],
])

@formField('browser', [
    'routePrefix' => 'visit',
    'moduleName' => 'customToursItems',
    'name' => 'custom_tours_items',
    'label' => 'Custom Tours',
    'max' => -1,
])

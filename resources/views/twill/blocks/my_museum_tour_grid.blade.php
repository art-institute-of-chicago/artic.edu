@twillBlockTitle('My Museum Tour Grid')
@twillBlockIcon('image')

@formField('wysiwyg', [
    'name' => 'my_museum_tour_grid_heading',
    'label' => 'Heading',
    'toolbarOptions' => [
        'italic'
    ],
])

@formField('wysiwyg', [
    'name' => 'my_museum_tour_grid_text',
    'label' => 'Intro Text',
    'toolbarOptions' => [
        'italic'
    ],
])

@formField('browser', [
    'routePrefix' => 'visit',
    'moduleName' => 'myMuseumTourItems',
    'name' => 'myMuseumTourItems',
    'label' => 'My Museum Tour',
    'max' => -1,
])

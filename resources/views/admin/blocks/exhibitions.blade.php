@twillBlockTitle('Exhibitions')
@twillBlockIcon('text')
@twillBlockComponent('a17-block-exhibitions')

@formField('input', [
    'name' => 'title',
    'label' => 'Title',
])

@formField('browser', [
    'routePrefix' => 'exhibitions_events',
    'max' => 4,
    'moduleName' => 'exhibitions',
    'name' => 'exhibitions',
    'label' => 'Exhibitions'
])

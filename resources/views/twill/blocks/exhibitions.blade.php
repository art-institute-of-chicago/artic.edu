@twillBlockTitle('Exhibitions')
@twillBlockIcon('text')

<x-twill::input
    name='title'
    label='Title'
/>

@formField('browser', [
    'routePrefix' => 'exhibitionsEvents',
    'max' => 4,
    'moduleName' => 'exhibitions',
    'name' => 'exhibitions',
    'label' => 'Exhibitions'
])

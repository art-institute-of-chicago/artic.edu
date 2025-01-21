@twillBlockTitle('My Museum Tour Grid')
@twillBlockIcon('image')

<x-twill::wysiwyg
    name='my_museum_tour_grid_heading'
    label='Heading'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::wysiwyg
    name='my_museum_tour_grid_text'
    label='Intro Text'
    :toolbar-options="[ 'italic' ]"
/>

@formField('browser', [
    'routePrefix' => 'visit',
    'moduleName' => 'myMuseumTourItems',
    'name' => 'myMuseumTourItems',
    'label' => 'My Museum Tour',
    'max' => -1,
])

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

<x-twill::browser
    name='myMuseumTourItems'
    label='My Museum Tour'
    route-prefix='visit'
    module-name='myMuseumTourItems'
    :max='-1'
/>

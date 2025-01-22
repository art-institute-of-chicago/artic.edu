@twillBlockTitle('Exhibitions')
@twillBlockIcon('text')

<x-twill::input
    name='title'
    label='Title'
/>

<x-twill::browser
    name='exhibitions'
    label='Exhibitions'
    route-prefix='exhibitionsEvents'
    module-name='exhibitions'
    :max='4'
/>

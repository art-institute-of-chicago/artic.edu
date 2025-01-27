@twillBlockTitle('Grid')
@twillBlockIcon('image')

<x-twill::wysiwyg
    name='heading'
    label='Heading'
    :maxlength='60'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::input
    name='grid_link_label'
    label='Link Label'
    note='Displayed at top-right of title bar'
    :maxlength='60'
/>

<x-twill::input
    name='grid_link_href'
    label='Link URL'
    :maxlength='60'
/>

<x-twill::repeater
    type="grid_item"
/>

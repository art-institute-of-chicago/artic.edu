@twillBlockTitle('Grid')
@twillBlockTitleField('heading')
@twillBlockIcon('image')

@include('twill.partials.gridded')

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

@twillBlockTitle('Grid')
@twillBlockTitleField('heading')
@twillBlockIcon('image')

@include('twill.partials.gridded')

<x-twill::repeater
    type="grid_item"
/>

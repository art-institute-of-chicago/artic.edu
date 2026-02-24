@twillBlockTitle('Playlist Grid')
@twillBlockTitleField('heading')
@twillBlockIcon('flex-grid')

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

<x-twill::wysiwyg
    name='description'
    label='Description'
    :toolbar-options="[ 'italic' ]"
/>
<x-twill::browser
    name='playlists'
    label='Playlists'
    route-prefix='collection.articlesPublications'
    module-name='playlists'
    sortable='true'
    :max='4'
/>

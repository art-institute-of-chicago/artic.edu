@twillBlockTitle('Playlist Grid')
@twillBlockTitleField('heading')
@twillBlockIcon('flex-grid')

@include('twill.partials.gridded')

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

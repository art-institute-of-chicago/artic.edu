@twillBlockTitle('Video Grid')
@twillBlockTitleField('heading')
@twillBlockIcon('flex-grid')

@include('twill.partials.gridded')

<x-twill::radios
    name='display'
    label='Display'
    default='recent'
    :inline='true'
    :options="[
        [
            'value' => 'category',
            'label' => 'Category'
        ],
        [
            'value' => 'playlist',
            'label' => 'Playlist'
        ],
        [
            'value' => 'featured',
            'label' => 'Featured'
        ],
    ]"
/>
<x-twill::formConnectedFields
    field-name='display'
    field-values='category'
    :render-for-blocks='true'
    :keep-alive='true'
>
    <x-twill::browser
        name='videoCategories'
        label='Video Category'
        route-prefix='collection.articlesPublications'
        module-name='videoCategories'
        sortable='false'
        :max='1'
    />
</x-twill::formConnectedFields>
<x-twill::formConnectedFields
    field-name='display'
    field-values='playlist'
    :render-for-blocks='true'
    :keep-alive='true'
>
    <x-twill::browser
        name='playlist'
        label='Playlist'
        route-prefix='collection.articlesPublications'
        module-name='playlists'
        sortable='false'
        :max='1'
    />
</x-twill::formConnectedFields>
<x-twill::formConnectedFields
    field-name='display'
    field-values='featured'
    :render-for-blocks='true'
    :keep-alive='true'
>
    <x-twill::browser
        name='videos'
        label='Videos'
        note='Feature videos'
        route-prefix='collection.articlesPublications'
        module-name='videos'
        :max='8'
    />
</x-twill::formConnectedFields>
<x-twill::checkbox
    name="show_description"
    label="Show video descriptions"
/>

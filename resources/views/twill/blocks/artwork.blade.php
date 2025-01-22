@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
@endphp

@twillBlockTitle('Artwork')
@twillBlockIcon('image')

@if ($type === 'digitalPublications')
    <x-twill::checkbox
        name='hide_figure_number'
        label='Hide figure number'
        default='false'
    />
@endif

<x-twill::select
    name='size'
    label='Size'
    placeholder='Select size'
    default='{{ $type === 'digitalPublications' ? 'l' : 'm' }}'
    disabled='{{ $type === 'digitalPublications' ? true : false }}'
    :options="[
        [
            'value' => 's',
            'label' => 'Small'
        ],
        [
            'value' => 'm',
            'label' => 'Medium'
        ],
        [
            'value' => 'l',
            'label' => 'Large'
        ]
    ]"
/>

<p>Note: if the chosen artwork does not have rights to be viewed at a large size, it will display as size small</p>

<x-twill::browser
    name='artworks'
    label='Artworks'
    route-prefix='collection'
    module-name='artworks'
    :max='1'
/>

<x-twill::wysiwyg
    name='captionAddendum'
    label='Caption addendum'
    note='Appended to generated tombstone'
    :toolbar-options="[ 'italic', 'link' ]"
/>

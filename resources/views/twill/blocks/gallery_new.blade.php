@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
@endphp

@twillBlockTitle('Gallery')
@twillBlockIcon('image')

{{-- WEB-1251: Inline contents partial for shared gallery block --}}
@include('twill.partials.gallery-shared')

@if ($type === 'digitalPublications')
    <x-twill::checkbox
        name='hide_figure_number'
        label='Hide figure number'
        default='false'
    />
@endif

<x-twill::wysiwyg
    name='title'
    label='Title'
    :maxlength='60'
    :toolbar-options="[ 'italic', 'link' ]"
/>

<x-twill::wysiwyg
    name='description'
    label='Description'
    note='Will be hidden if title is empty'
    :maxlength='500'
    :rows='4'
    :toolbar-options="[ 'italic', 'link' ]"
/>

<x-twill::checkbox
    name='disable_gallery_modals'
    label='Disable modals for this gallery'
/>

<x-twill::checkbox
    name='is_gallery_zoomable'
    label='Make all image modals zoomable (override)'
/>

@formField('repeater', [
    'type' => 'gallery_new_item',
])

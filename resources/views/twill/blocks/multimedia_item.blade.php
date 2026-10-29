@twillBlockTitle('Multimedia Item')
@twillBlockIcon('image')

@php
    $endpoints = [
        [
            'label' => 'Digital Explorer',
            'value' => '/collection/digitalExplorers/browser'
        ],
        [
            'label' => 'Layered Image Viewer',
            'value' => '/collection/artworks/layered-image-viewer-blocks/browser'
        ],
        [
            'label' => 'Video',
            'value' => '/collection/articlesPublications/videos/browser'
        ],
        [
            'label' => 'Mirador',
            'value' => '/exhibitionsEvents/miradors/browser'
        ],
    ];
@endphp

<x-twill::browser
    name='multimedia_item'
    label='Item'
    note='The item to show (digital explorer, layered image viewer, video, or Mirador)'
    :max='1'
    :endpoints="$endpoints"
/>

<p>
    <strong>Section heading</strong><br>
    Leave these blank to use the standard heading for the item's section.
    For Mirador, Title and Description label the viewer; leave Title blank to use the Mirador record title.
</p>

<x-twill::input
    name='section_title'
    label='Section title'
    note='Overrides the standard section title'
    :maxlength='100'
/>

<x-twill::wysiwyg
    name='description'
    label='Section description'
    note='Overrides the standard section description'
    :toolbar-options="[ 'italic', 'link' ]"
/>

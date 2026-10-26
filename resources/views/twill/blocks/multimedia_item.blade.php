@twillBlockTitle('Multimedia Item')
@twillBlockIcon('image')

@php
    $endpoints = [
        [
            'label' => 'Interactive Feature',
            'value' => '/collection/interactiveFeatures/experiences/browser'
        ],
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
    ];
@endphp

<x-twill::browser
    name='multimedia_item'
    label='Item'
    note='The interactive feature, digital explorer, layered image viewer, or video to show'
    :max='1'
    :endpoints="$endpoints"
/>

<p>
    <strong>Section heading</strong><br>
    Leave these blank to use the standard heading for the item's section.
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

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

<x-twill::checkbox
    name='mirador_settings'
    label='Custom Mirador settings'
    note='Override for mirador non are selected'
    :default="false"
/>

<x-twill::formConnectedFields
    field-name='mirador_settings'
    :field-values="true"
    :render-for-blocks='true'
    :keep-alive='true'
>
    @php
        $note = 'i.e. ' . config('api.public_uri') . '/api/v1/artworks/{objectId}/manifest.json';
    @endphp
    <x-twill::checkbox
        name='default_manifest_url'
        label='Use default manifest file.'
        :note="$note"
        :default="false"
    />
    <x-twill::files
        name='upload_manifest_file'
        label='Alternative manifest file'
        note='Upload a .json file'
    />
    <x-twill::radios
        name='default_view'
        label='Default View'
        :inline='true'
        :options="[
            [
                'value' => 'single',
                'label' => 'Single'
            ],
            [
                'value' => 'book',
                'label' => 'Book'
            ]
        ]"
    />
</x-twill::formConnectedFields>

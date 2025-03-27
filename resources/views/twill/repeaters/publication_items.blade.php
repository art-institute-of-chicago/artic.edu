@twillRepeaterTitle('Publications Item')
@twillRepeaterTrigger('Add publications item')
{{-- @twillRepeaterComponent('a17-block-publication_items') --}}

@php
    $endpoints = [
        [
            'label' => 'Digital Publications',
            'name' => 'collection.articlesPublications.digitalPublications'
        ],
        [
            'label' => 'Print Publications',
            'name' => 'collection.articlesPublications.printedPublications'
        ],
    ];

    $params = [
        'published' => true,
        'is_published' => true
    ];
@endphp

<x-twill::formColumns>

    <x-slot:left>
        <x-twill::browser
            name='publication_item'
            label="Publication"
            note='Highlighted publication'
            :max='1'
            :modules='$endpoints'
            :params='$params'
        />
    </x-slot>

    <x-slot:right>
        <x-twill::medias
            name='listing_image'
            label='Custom Image'
            note='Overrides Item Image'
            :max='1'
        />
    </x-slot>

</x-twill::formColumns>

<x-twill::formColumns>

    <x-slot:left>
        <x-twill::input
            name='title'
            label='Title'
            note='Overrides Item Title'
        />
        <x-twill::input
            name='linkUrl'
            label='Link Url'
            note='Overrides Item Link'
        />
    </x-slot>

    <x-slot:right>
        <x-twill::input
            name='label'
            label='Eyebrow label'
            note='Overrides Type Label'
        />
    </x-slot>

</x-twill::formColumns>

<x-twill::wysiwyg
    name='description'
    label='Description'
    note='Rendered only on first item'
    :toolbar-options="[ 'italic', 'link' ]"
/>
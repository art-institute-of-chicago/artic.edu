@twillRepeaterTitle('Media Item')
@twillRepeaterTrigger('Add video item')

@php
    $endpoints = [
        [
            'label' => 'Interactive feature',
            'value' => '/collection/interactiveFeatures/experiences/browser?published=true&is_published=true'
        ],
        [
            'label' => 'Video',
            'value' => '/collection/articlesPublications/videos/browser?published=true&is_published=true'
        ],
        [
            'label' => 'Educator Resources',
            'value' => '/collection/researchResources/educatorResources/browser?published=true&is_published=true'
        ]
    ];

    $params = [
        'published' => true,
        'is_published' => true
    ];
@endphp

<x-twill::formColumns>

    <x-slot:left>
        <x-twill::browser
            name='media_item'
            label="Media"
            note='Highlighted media'
            :max='1'
            :endpoints="[
                [
                    'label' => 'Interactive feature',
                    'value' => '/collection/interactiveFeatures/experiences/browser?published=true&is_published=true'
                ],
                [
                    'label' => 'Video',
                    'value' => '/collection/articlesPublications/videos/browser?published=true&is_published=true'
                ],
                [
                    'label' => 'Educator Resources',
                    'value' => '/collection/researchResources/educatorResources/browser?published=true&is_published=true'
                ]
            ]"
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
    note='Overrides item description'
    :toolbar-options="[ 'italic', 'link' ]"
/>
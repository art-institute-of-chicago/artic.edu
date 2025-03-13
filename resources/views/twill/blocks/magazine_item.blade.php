@twillBlockTitle('Magazine Item')
@twillBlockIcon('text')

@php
    $options = [
        [
            'value' => \App\Models\MagazineItem::ITEM_TYPE_ARTICLE,
            'label' => 'Article'
        ],
        [
            'value' => \App\Models\MagazineItem::ITEM_TYPE_HIGHLIGHT,
            'label' => 'Highlights'
        ],
        [
            'value' => \App\Models\MagazineItem::ITEM_TYPE_EXPERIENCE,
            'label' => 'Interactive Features'
        ],
        [
            'value' => \App\Models\MagazineItem::ITEM_TYPE_CUSTOM,
            'label' => 'Custom'
        ]
    ];
@endphp

<x-twill::radios
    name='feature_type'
    label='Feature type'
    default='\App\Models\MagazineItem::ITEM_TYPE_ARTICLE'
    :inline='true'
    :options="$options"
/>

<x-twill::formConnectedFields
    field-name='feature_type'
    field-values="{{ \App\Models\MagazineItem::ITEM_TYPE_ARTICLE }}"
    :render-for-blocks='true'
>
    <x-twill::browser
        name='{{ \App\Models\MagazineItem::ITEM_TYPE_ARTICLE }}'
        label='Article'
        route-prefix='collection.articlesPublications'
        module-name='articles'
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='feature_type'
    field-values="{{ \App\Models\MagazineItem::ITEM_TYPE_HIGHLIGHT }}"
    :render-for-blocks='true'
>
    <x-twill::browser
        name='{{ \App\Models\MagazineItem::ITEM_TYPE_HIGHLIGHT }}'
        label='Highlight'
        route-prefix='collection'
        module-name='highlights'
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='feature_type'
    field-values="{{ \App\Models\MagazineItem::ITEM_TYPE_EXPERIENCE }}"
    :render-for-blocks='true'
>
    <x-twill::browser
        name='{{ \App\Models\MagazineItem::ITEM_TYPE_EXPERIENCE }}'
        label='Interactive Feature'
        route-prefix='collection.interactiveFeatures'
        module-name='experiences'
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='feature_type'
    field-values="{{ \App\Models\MagazineItem::ITEM_TYPE_CUSTOM }}"
    :render-for-blocks='true'
    :keep-alive='true'
>
    <x-twill::medias
        name='listing_image'
        label='Hero image'
    />

    <x-twill::input
        name='tag'
        label='Tag'
        note='Small text e.g. "Exhibition"'
    />

    <x-twill::input
        name='title'
        label='Title'
        note='Use <i> tag to add italics, e.g. <i>Nighthawks</i>'
    />

    <x-twill::input
        name='url'
        label='URL for link'
    />

    <x-twill::input
        name='author_display'
        label='Author'
    />
</x-twill::formConnectedFields>

<x-twill::wysiwyg
    name='list_description'
    label='List description'
    note='Max 255 characters'
    :maxlength='255'
    :toolbar-options="[ 'italic' ]"
/>

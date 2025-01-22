@twillBlockTitle('Magazine Item')
@twillBlockIcon('text')

<x-twill::radios
    name='feature_type'
    label='Feature type'
    default='\App\Models\MagazineItem::ITEM_TYPE_ARTICLE'
    :inline='true'
    :options="[
        [
            'value' => '{{ \App\Models\MagazineItem::ITEM_TYPE_ARTICLE }}',
            'label' => 'Article'
        ],
        [
            'value' => '{{ \App\Models\MagazineItem::ITEM_TYPE_HIGHLIGHT }}',
            'label' => 'Highlights'
        ],
        [
            'value' => '{{ \App\Models\MagazineItem::ITEM_TYPE_EXPERIENCE }}',
            'label' => 'Interactive Features'
        ],
        [
            'value' => '{{ \App\Models\MagazineItem::ITEM_TYPE_CUSTOM }}',
            'label' => 'Custom'
        ]
    ]"
/>

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => \App\Models\MagazineItem::ITEM_TYPE_ARTICLE,
    'renderForBlocks' => true
])
    <x-twill::browser
        name='{{ \App\Models\MagazineItem::ITEM_TYPE_ARTICLE }}'
        label='Article'
        route-prefix='collection.articlesPublications'
        module-name='articles'
    />
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => \App\Models\MagazineItem::ITEM_TYPE_HIGHLIGHT,
    'renderForBlocks' => true
])
    <x-twill::browser
        name='{{ \App\Models\MagazineItem::ITEM_TYPE_HIGHLIGHT }}'
        label='Highlight'
        route-prefix='collection'
        module-name='highlights'
    />
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => \App\Models\MagazineItem::ITEM_TYPE_EXPERIENCE,
    'renderForBlocks' => true
])
    <x-twill::browser
        name='{{ \App\Models\MagazineItem::ITEM_TYPE_EXPERIENCE }}'
        label='Interactive Feature'
        route-prefix='collection.interactiveFeatures'
        module-name='experiences'
    />
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => \App\Models\MagazineItem::ITEM_TYPE_CUSTOM,
    'renderForBlocks' => true
])
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
@endcomponent

<x-twill::wysiwyg
    name='list_description'
    label='List description'
    note='Max 255 characters'
    :maxlength='255'
    :toolbar-options="[ 'italic' ]"
/>

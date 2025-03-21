@twillRepeaterTitle('Gallery Item')
@twillRepeaterTrigger('Add gallery item')
@twillRepeaterComponent('a17-block-gallery_new_item')

@php
    $options = [
        [
            'value' => \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_CUSTOM,
            'label' => 'Custom',
        ],
        [
            'value' => \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_CUSTOM_WITH_LINK,
            'label' => 'Custom with link',
        ],
        [
            'value' => \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_ARTWORK,
            'label' => 'Artwork',
        ]
    ];
@endphp

<x-twill::radios
    name='gallery_item_type'
    label='Gallery item type'
    default='\App\Models\Vendor\Block::GALLERY_ITEM_TYPE_CUSTOM'
    :inline='true'
    :options="$options"
/>

<x-twill::formConnectedFields
    field-name='gallery_item_type'
    field-values="{{ \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_CUSTOM }}"
    :render-for-blocks='true'
    :keep-alive='true'
>
    <x-twill::medias
        name='image'
        label='Image'
        :max='1'
    />

    <x-twill::wysiwyg
        name='captionTitle'
        label='Caption title'
        :toolbar-options="[ 'italic', 'link' ]"
    />

    <x-twill::wysiwyg
        name='captionText'
        label='Caption text'
        :toolbar-options="[ 'italic', 'link' ]"
    />

    <x-twill::input
        name='videoUrl'
        label='YouTube URL'
        note='Provide to show video in modal instead of image'
    />

    <x-twill::checkbox
        name='is_zoomable'
        label='Make this image modal zoomable'
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='gallery_item_type'
    field-values="{{ \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_CUSTOM_WITH_LINK }}"
    :render-for-blocks='true'
>
    <x-twill::medias
        name='gallery_item'
        label='Image'
        :max='1'
    />

    <x-twill::wysiwyg
        name='captionTitle'
        label='Caption title'
        :toolbar-options="[ 'italic', 'link' ]"
    />

    <x-twill::wysiwyg
        name='captionText'
        label='Caption text'
        :toolbar-options="[ 'italic', 'link' ]"
    />

    <x-twill::input
        name='linkUrl'
        label='Link URL'
    />

    <x-twill::input
        name='linkLabel'
        label='Link Label'
        default='Learn more >'
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='gallery_item_type'
    field-values="{{ \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_ARTWORK }}"
    :render-for-blocks='true'
    :keep-alive='true'
>
    <x-twill::browser
        name='artworks'
        label='Artwork'
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
</x-twill::formConnectedFields>

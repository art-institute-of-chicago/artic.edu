@twillRepeaterTitle('Gallery Item')
@twillRepeaterTrigger('Add gallery item')
@twillRepeaterComponent('a17-block-gallery_new_item')

@formField('radios', [
    'name' => 'gallery_item_type',
    'label' => 'Gallery item type',
    'default' => \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_CUSTOM,
    'inline' => true,
    'options' => [
        [
            'value' => \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_CUSTOM,
            'label' => 'Custom',
        ],
        [
            'value' => \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_ARTWORK,
            'label' => 'Artwork',
        ],
    ]
])

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'gallery_item_type',
    'fieldValues' => \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_CUSTOM,
    'renderForBlocks' => true
])
    @formField('medias', [
        'name' => 'image',
        'label' => 'Image',
        'max' => 1
    ])

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
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'gallery_item_type',
    'fieldValues' => \App\Models\Vendor\Block::GALLERY_ITEM_TYPE_ARTWORK,
    'renderForBlocks' => true
])
    @formField('browser', [
        'routePrefix' => 'collection',
        'name' => 'artworks',
        'moduleName' => 'artworks',
        'label' => 'Artwork',
        'max' => 1
    ])

    <x-twill::wysiwyg
        name='captionAddendum'
        label='Caption addendum'
        note='Appended to generated tombstone'
        :toolbar-options="[ 'italic', 'link' ]"
    />
@endcomponent

@twillRepeaterTitle('Image')
@twillRepeaterTrigger('Add image')

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

    @formField('checkbox', [
        'name' => 'is_zoomable',
        'label' => 'Make this image modal zoomable',
    ])
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

    @formField('wysiwyg', [
        'name' => 'captionAddendum',
        'label' => 'Caption addendum',
        'note' => 'Appended to generated tombstone',
        'toolbarOptions' => [
            'italic', 'link',
        ],
    ])
@endcomponent

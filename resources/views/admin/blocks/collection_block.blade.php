@twillBlockTitle('Collection Block')
@twillBlockIcon('Image')

@formField('input', [
    'name' => 'collection_heading',
    'label' => 'Heading'
])

{{-- @formField('browser', [
    'routePrefix' => 'collection',
    'max' => 20,
    'moduleName' => 'artworks',
    'name' => 'landingArtworks',
    'label' => 'Artworks'
]) --}}

@formField('browser', [
    'name' => 'artworks',
    'endpoints' => [
            [
                'label' => 'Artworks',
                'value' => moduleRoute('artworks', 'collection', 'browser', [], false)
            ]
        ],
    'label' => 'Artworks',
    'max' => 20,
])

@formField('wysiwyg', [
    'name' => 'bottom_desc',
    'label' => 'Description',
    'type' => 'textarea'
])

@formField('input', [
    'name' => 'primary_button_label',
    'label' => 'Primary Button Label'
])

@formField('input', [
    'name' => 'primary_button_link',
    'label' => 'Primary Button Link'
])

@formField('input', [
    'name' => 'secondary_button_label',
    'label' => 'Secondary Button Label'
])

@formField('input', [
    'name' => 'secondary_button_link',
    'label' => 'Secondary Button Link'
])
@twillBlockTitle('Artwork')
@twillBlockIcon('image')
@twillBlockComponent('a17-block-artwork')

@formField('browser', [
    'routePrefix' => 'collection',
    'name' => 'artworks',
    'moduleName' => 'artworks',
    'label' => 'Artworks',
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

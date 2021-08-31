@twillBlockTitle('Artwork')
@twillBlockIcon('image')

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

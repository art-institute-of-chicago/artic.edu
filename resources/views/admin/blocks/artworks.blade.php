@formField('browser', [
    'routePrefix' => 'collection',
    'name' => 'artworks',
    'moduleName' => 'artworks',
    'label' => 'Artworks',
    'max' => 100
])

@include('admin.partials.gallery-shared')

@formField('input', [
    'name' => 'title',
    'label' => 'Gallery Title',
    'maxlength' => 150
])

@formField('input', [
    'name' => 'subhead',
    'label' => 'Image Subhead'
])


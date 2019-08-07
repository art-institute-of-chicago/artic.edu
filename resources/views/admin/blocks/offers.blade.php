@formField('medias', [
    'name' => 'hero',
    'label' => 'Image',
    'max' => '1'
])

@formField('input', [
    'name' => 'title',
    'label' => 'Title'
])

@formField('input', [
    'type' => 'textarea',
    'name' => 'description',
    'label' => 'Description',
    'rows' => 4
])

@formField('input', [
    'name' => 'label',
    'label' => 'Label',
    'note' => 'Displayed at bottom-right of image',
])

@formField('input', [
    'name' => 'url',
    'label' => 'URL'
])

@formField('input', [
    'name' => 'time',
    'label' => 'Time'
])

@formField('input', [
    'name' => 'title',
    'label' => 'Title'
])

@formField('wysiwyg', [
    'name' => 'description',
    'label' => 'Description',
    'toolbarOptions' => [
        'italic', 'link'
    ],
])

@formField('medias', [
    'name' => 'image',
    'label' => 'Image',
    'max' => '1'
])

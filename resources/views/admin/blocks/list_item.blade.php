@formField('medias', [
    'name' => 'image',
    'label' => 'Image',
    'max' => '1'
])

@formField('input', [
    'name' => 'tag',
    'label' => 'Tag',
    'maxlength' => 20
])

@formField('input', [
    'name' => 'header',
    'label' => 'Header',
    'maxlength' => 60
])

@formField('wysiwyg', [
    'name' => 'description',
    'label' => 'Description',
    'rows' => 4,
    'toolbarOptions' => [
        'italic', 'link'
    ],
])

@formField('input', [
    'name' => 'external_link',
    'label' => 'Link'
])

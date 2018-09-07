@formField('medias', [
    'name' => 'image',
    'label' => 'Image',
    'max' => 1
])

@formField('wysiwyg', [
    'name' => 'captionTitle',
    'label' => 'Caption title',
    'maxlength' => 80,
    'note' => 'Max 80 characters',
    'toolbarOptions' => [
        'italic',
    ],
])

@formField('wysiwyg', [
    'name' => 'caption',
    'label' => 'Caption',
    'maxlength' => 200,
    'note' => 'Max 200 characters',
    'toolbarOptions' => [
        'italic',
    ],
])

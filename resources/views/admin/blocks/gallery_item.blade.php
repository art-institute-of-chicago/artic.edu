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
    'maxlength' => 300,
    'note' => 'Max 300 characters',
    'toolbarOptions' => [
        'italic', 'link',
    ],
])

@formField('input', [
    'name' => 'videoUrl',
    'label' => 'YouTube URL',
    'note' => 'Provide to show video in modal instead of image',
])

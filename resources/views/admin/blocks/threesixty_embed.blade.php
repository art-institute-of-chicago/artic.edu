@twillBlockTitle('title')

@formField('files', [
    'name' => 'image_sequence_file',
    'label' => '360 Zip',
    'note' => 'Upload a .zip file'
])

@formField('input', [
    'name' => 'alt_text',
    'label' => 'Alt Text',
])

@formField('wysiwyg', [
    'name' => 'caption_title',
    'label' => 'Caption title',
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

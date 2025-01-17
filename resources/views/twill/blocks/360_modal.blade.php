@twillBlockTitle('360 Modal')
@twillBlockIcon('image')

@formField('medias', [
    'name' => 'image',
    'label' => '360 Image',
    'max' => '1',
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

@formField('files', [
    'name' => 'image_sequence_file',
    'label' => '360 Zip',
    'note' => 'Upload a .zip file',
])

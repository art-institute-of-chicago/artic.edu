@twillBlockTitle('Mirador Embed')
@twillBlockIcon('image')

@formField('input', [
    'type' => 'number',
    'name' => 'objectId',
    'label' => 'Object ID',
    'note' => 'Enter object ID to obtain manifest dynamically.'
])

@formField('files', [
    'name' => 'upload_manifest_file',
    'label' => 'Alternative manifest file',
    'note' => 'Upload a .json file'
])

@formField('select', [
    'name' => 'size',
    'label' => 'Size',
    'placeholder' => 'Select size',
    'default' => 'm',
    'options' => [
        [
            'value' => 's',
            'label' => 'Small'
        ],
        [
            'value' => 'm',
            'label' => 'Medium'
        ],
        [
            'value' => 'l',
            'label' => 'Large'
        ]
    ]
])

@formField('radios', [
    'name' => 'default_view',
    'label' => 'Default View',
    'default' => 'single',
    'inline' => true,
    'options' => [
        [
            'value' => 'single',
            'label' => 'Single'
        ],
        [
            'value' => 'book',
            'label' => 'Book'
        ],
    ]
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

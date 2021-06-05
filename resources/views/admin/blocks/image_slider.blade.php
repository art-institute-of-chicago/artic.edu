@twillBlockTitle('Image Slider')
@twillBlockIcon('image')

@formField('checkbox', [
    'name' => 'is_slider_zoomable',
    'label' => 'Enable zoom',
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

@formField('wysiwyg', [
    'name' => 'caption_title',
    'label' => 'Caption title',
    'toolbarOptions' => [
        'italic',
    ],
])

@formField('wysiwyg', [
    'name' => 'caption_text',
    'label' => 'Caption text',
    'maxlength' => 300,
    'note' => 'Max 300 characters',
    'toolbarOptions' => [
        'italic', 'link',
    ],
])

<hr>

@formField('medias', [
    'name' => 'left_image',
    'label' => 'Left image',
])

@formField('medias', [
    'name' => 'right_image',
    'label' => 'Right image',
])

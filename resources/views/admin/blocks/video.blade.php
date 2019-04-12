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

@formField('medias', [
    'name' => 'image',
    'label' => 'Thumbnail image'
])

<p>For <strong>YouTube</strong>, we recommend using <a href="https://www.youtube.com/watch?v=LFF68_bME9E">full URLs</a> instead of <a href="https://youtu.be/LFF68_bME9E">shortened ones</a>.</p>

@formField('input', [
    'name' => 'url',
    'label' => 'Video URL'
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
    'maxlength' => 200,
    'note' => 'Max 200 characters',
    'toolbarOptions' => [
        'italic', 'link',
    ],
])

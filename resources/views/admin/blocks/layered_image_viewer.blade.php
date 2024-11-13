@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
@endphp

@twillBlockTitle('Layered Image Viewer')
@twillBlockIcon('image')

@formField('wysiwyg', [
    'name' => 'caption_title',
    'label' => 'Caption title',
    'toolbarOptions' => [
        'italic', 'link',
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

@formField('select', [
    'name' => 'size',
    'label' => 'Size',
    'placeholder' => 'Select size',
    'default' => ($type === 'digitalPublications' ? 'l' : 'm'),
    'disabled' => ($type === 'digitalPublications' ? true : false),
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

@formField('repeater', ['type' => 'layered_image_viewer_img'])

@formField('repeater', ['type' => 'layered_image_viewer_overlay'])

@twillBlockTitle('Video')
@twillBlockIcon('image')

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
    'name' => 'media_type',
    'label' => 'Media type',
    'default' => 'youtube',
    'inline' => true,
    'options' => [
        [
            'value' => 'youtube',
            'label' => 'YouTube embed'
        ],
        [
            'value' => 'loop',
            'label' => 'Video loop'
        ],
    ]
])

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'media_type',
    'fieldValues' => 'loop',
    'renderForBlocks' => true
])
    @formField('medias', [
        'name' => 'image',
        'label' => 'Video loop'
    ])

    @formField('radios', [
        'name' => 'loop_or_once',
        'label' => 'Loop or play just once?',
        'default' => 'loop',
        'inline' => true,
        'options' => [
            [
                'value' => 'loop',
                'label' => 'Loop'
            ],
            [
                'value' => 'just_once',
                'label' => 'Play just once'
            ],
        ]
    ])

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'media_type',
    'fieldValues' => 'youtube',
    'renderForBlocks' => true
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

@endcomponent

@formField('checkbox', [
    'name' => 'use_alt_background',
    'label' => 'Use white instead of gray to pillarbox the image',
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

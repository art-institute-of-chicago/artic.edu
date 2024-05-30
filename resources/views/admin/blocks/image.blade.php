@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;

    switch ($type) {
        case 'digitalPublications':
            $themes = ['default', 'Digital Publication'];
            break;
        default:
            $themes = ['default'];
    }
@endphp

@twillBlockTitle('Image')
@twillBlockIcon('image')

@formField('select', [
    'name' => 'theme',
    'label' => 'Theme',
    'default' => 'default',
    'disabled' => count($themes) === 1,
    'options' => collect($themes)->map(function($theme) {
        return [
            'value' => Str::slug($theme),
            'label' => ucfirst($theme),
        ];
    })->toArray(),
])

    @formConnectedFields([
        'fieldName' => 'theme',
        'fieldValues' => 'default',
        'renderForBlocks' => true,
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

    @formField('checkbox', [
        'name' => 'use_contain',
        'label' => 'Always show the whole image instead of cropping to the container',
    ])

    @formField('checkbox', [
        'name' => 'use_alt_background',
        'label' => 'Use white instead of gray to pillarbox the image',
    ])

    @formField('checkbox', [
        'name' => 'is_modal',
        'label' => 'Allow this image to be viewed in a modal',
    ])

    @formField('checkbox', [
        'name' => 'is_zoomable',
        'label' => 'Make the image modal zoomable',
    ])

    @formField('medias', [
        'name' => 'image',
        'label' => 'Image'
    ])

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

    @formField('input', [
        'name' => 'image_link',
        'label' => 'Link (optional)',
        'note' => 'Makes image clickable',
    ])

@endcomponent

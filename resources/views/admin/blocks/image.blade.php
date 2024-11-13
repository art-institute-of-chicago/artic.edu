@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
    $options = [];
    $options[] = [
        'value' => 's',
        'label' => 'Small'
    ];

    if ($type !== 'digitalPublications') {  // replace $condition with your actual condition
        $options[] = [
            'value' => 'm',
            'label' => 'Medium'
        ];
    }

    $options[] = [
        'value' => 'l',
        'label' => 'Large'
    ];
@endphp

@twillBlockTitle('Image')
@twillBlockIcon('image')

@if ($type === 'digitalPublications')
    @formField('checkbox', [
        'name' => 'hide_figure_number',
        'label' => 'Hide figure number',
        'default' => false,
    ])
@endif

@formField('select', [
    'name' => 'size',
    'label' => 'Size',
    'placeholder' => 'Select size',
    'default' => ($type === 'digitalPublications' ? 'l' : 'm'),
    'options' => $options,
])

@formField('checkbox', [
    'name' => 'use_contain',
    'label' => 'Always show the whole image instead of cropping to the container',
    'default' => ($type === 'digitalPublications' ? true : false),
    'disabled' => ($type === 'digitalPublications' ? true : false),
])

@formField('checkbox', [
    'name' => 'use_alt_background',
    'label' => 'Use white instead of gray to pillarbox the image',
    'default' => ($type === 'digitalPublications' ? true : false),
    'disabled' => ($type === 'digitalPublications' ? true : false),
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
    'type' => 'text'
])

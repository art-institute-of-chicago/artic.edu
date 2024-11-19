@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
@endphp

@twillBlockTitle('Media embed')
@twillBlockIcon('text')

@formField('select', [
    'name' => 'size',
    'label' => 'Size',
    'placeholder' => 'Select size',
    'default' => ($type === 'digitalPublications' ? 'l' : 's'),
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

@formField('radios', [
    'name' => 'embed_type',
    'label' => 'Embed type',
    'default' => 'html',
    'inline' => true,
    'options' => [
        [
            'value' => 'html',
            'label' => 'HTML code'
        ],
        [
            'value' => 'url',
            'label' => 'Embed URL'
        ],
    ]
])

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'embed_type',
    'fieldValues' => 'html',
    'renderForBlocks' => true
])
    @formField('input', [
        'name' => 'embed_code',
        'label' => 'Media embed code',
        'type' => 'textarea'
    ])
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'embed_type',
    'fieldValues' => 'url',
    'renderForBlocks' => true
])
    @formField('input', [
        'name' => 'embed_url',
        'label' => 'Media embed URL',
    ])
@endcomponent

@formField('input', [
    'name' => 'embed_height',
    'label' => 'Height override',
    'note' => 'Optional. Use CSS units, e.g. "400px"',
])

@formField('checkbox', [
    'name' => 'disable_placeholder',
    'label' => 'Disable placeholder element',
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

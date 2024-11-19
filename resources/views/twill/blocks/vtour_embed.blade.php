@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
@endphp

@twillBlockTitle('Virtual Tour Embed')
@twillBlockIcon('image')

@formField('files', [
    'name' => 'vtour_xml_file',
    'label' => 'Virtual tour XML file',
    'note' => 'Upload a .xml file'
])

@formField('select', [
    'name' => 'size',
    'label' => 'Size',
    'placeholder' => 'Select size',
    'default' => 'l',
    'disabled' => ($type === 'digitalPublications' ? true : false),
    'options' => [
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
    'name' => 'caption',
    'label' => 'Caption',
    'maxlength' => 300,
    'note' => 'Max 300 characters',
    'toolbarOptions' => [
    'italic', 'link',
    ],
])

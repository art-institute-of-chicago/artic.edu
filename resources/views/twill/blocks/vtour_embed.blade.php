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

<x-twill::select
    name='size'
    label='Size'
    placeholder='Select size'
    default='l'
    disabled='{{ $type === 'digitalPublications' ? true : false }}'
    :options="[
        [
            'value' => 'm',
            'label' => 'Medium'
        ],
        [
            'value' => 'l',
            'label' => 'Large'
        ]
    ]"
/>

<x-twill::wysiwyg
    name='caption_title'
    label='Caption title'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::wysiwyg
    name='caption'
    label='Caption'
    note='Max 300 characters'
    :maxlength='300'
    :toolbar-options="[ 'italic', 'link' ]"
/>

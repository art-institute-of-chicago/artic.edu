@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
@endphp

@twillBlockTitle('Mirador Embed')
@twillBlockIcon('image')

<x-twill::input
    type='number'
    name='objectId'
    label='Object ID'
    note='Enter object ID to obtain manifest dynamically.'
/>

<x-twill::files
    name='upload_manifest_file'
    label='Alternative manifest file'
    note='Upload a .json file'
/>

@php
    $default = $type === 'digitalPublications' ? 'l' : 'm';
    $disabled = $type === 'digitalPublications' ? true : false;
@endphp

<x-twill::select
    name='size'
    label='Size'
    placeholder='Select size'
    default='$default'
    disabled='$disabled'
    :options="[
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
    ]"
/>

<x-twill::radios
    name='default_view'
    label='Default View'
    default='single'
    :inline='true'
    :options="[
        [
            'value' => 'single',
            'label' => 'Single'
        ],
        [
            'value' => 'book',
            'label' => 'Book'
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

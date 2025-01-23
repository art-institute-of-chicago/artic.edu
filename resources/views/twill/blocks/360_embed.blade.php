@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
@endphp

@twillBlockTitle('360 Embed')
@twillBlockIcon('image')

<x-twill::select
    name='size'
    label='Size'
    placeholder='Select size'
    default='{{ $type === 'digitalPublications' ? 'l' : 's' }}'
    disabled='{{ $type === 'digitalPublications' ? true : false }}'
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

<x-twill::files
    name='image_sequence_file'
    label='360 Zip'
    note='Upload a .zip file'
/>

<x-twill::input
    name='alt_text'
    label='Alt Text'
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

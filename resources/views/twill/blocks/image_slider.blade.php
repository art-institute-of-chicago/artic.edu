@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
@endphp

@twillBlockTitle('Image Slider')
@twillBlockIcon('image')

<x-twill::checkbox
    name='is_slider_zoomable'
    label='Enable zoom'
/>

<x-twill::select
    name='size'
    label='Size'
    placeholder='Select size'
    default='{{ $type === 'digitalPublications' ? 'l' : 'm' }}'
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

<x-twill::wysiwyg
    name='caption_title'
    label='Caption title'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::wysiwyg
    name='caption_text'
    label='Caption text'
    note='Max 300 characters'
    :maxlength='300'
    :toolbar-options="[ 'italic', 'link' ]"
/>

<hr>

<x-twill::medias
    name='left_image'
    label='Left image'
/>

<x-twill::medias
    name='right_image'
    label='Right image'
/>

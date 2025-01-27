@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
@endphp

@twillBlockTitle('Layered Image Viewer')
@twillBlockIcon('image')

<x-twill::wysiwyg
    name='caption_title'
    label='Caption title'
    :toolbar-options="[ 'italic', 'link' ]"
/>

<x-twill::wysiwyg
    name='caption'
    label='Caption'
    note='Max 300 characters'
    :maxlength='300'
    :toolbar-options="[ 'italic', 'link' ]"
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

<x-twill::repeater
    type="layered_image_viewer_img"
/>

<x-twill::repeater
    type="layered_image_viewer_overlay"
/>

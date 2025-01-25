@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
    $options = [];
    $options[] = [
        'value' => 's',
        'label' => 'Small'
    ];

    if ($type !== 'digitalPublications') {
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
    <x-twill::checkbox
        name='hide_figure_number'
        label='Hide figure number'
        default='false'
    />
@endif

@php
    $default = $type === 'digitalPublications' ? 'l' : 'm';
@endphp

<x-twill::select
    name='size'
    label='Size'
    placeholder='Select size'
    default='$default'
    :options='$options'
/>

@php
    $default = $type === 'digitalPublications' ? true : false;
    $disabled = $type === 'digitalPublications' ? true : false;
@endphp

<x-twill::checkbox
    name='use_contain'
    label='Always show the whole image instead of cropping to the container'
    default='$default'
    disabled='$disabled'
/>

<x-twill::checkbox
    name='use_alt_background'
    label='Use white instead of gray to pillarbox the image'
    default='$default'
    disabled='$disabled'
/>

<x-twill::checkbox
    name='is_modal'
    label='Allow this image to be viewed in a modal'
/>

<x-twill::checkbox
    name='is_zoomable'
    label='Make the image modal zoomable'
/>

<x-twill::medias
    name='image'
    label='Image'
/>

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

<x-twill::input
    name='image_link'
    label='Link (optional)'
    note='Makes image clickable'
/>

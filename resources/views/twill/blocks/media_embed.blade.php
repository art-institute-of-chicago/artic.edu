@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
@endphp

@twillBlockTitle('Media embed')
@twillBlockIcon('text')

@php
    $default = $type === 'digitalPublications' ? 'l' : 's';
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
    name='embed_type'
    label='Embed type'
    default='html'
    :inline='true'
    :options="[
        [
            'value' => 'html',
            'label' => 'HTML code'
        ],
        [
            'value' => 'url',
            'label' => 'Embed URL'
        ]
    ]"
/>

<x-twill::formConnectedFields
    field-name='embed_type'
    field-values="html"
    :render-for-blocks='true'
>
    <x-twill::input
        name='embed_code'
        label='Media embed code'
        type='textarea'
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='embed_type'
    field-values="url"
    :render-for-blocks='true'
>
    <x-twill::input
        name='embed_url'
        label='Media embed URL'
    />
</x-twill::formConnectedFields>

<x-twill::input
    name='embed_height'
    label='Height override'
    note='Optional. Use CSS units, e.g. "400px"'
/>

<x-twill::checkbox
    name='disable_placeholder'
    label='Disable placeholder element'
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

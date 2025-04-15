@php
    $currentUrl = explode('/', request()->url());
    $type = $currentUrl[5] ?? null;
    if ($type) {
        if (in_array('landingPages', $currentUrl)) {
            $type = \App\Models\LandingPage::find(intval($currentUrl[5]))->type;
        }
    }
@endphp

@twillBlockTitle('Gallery')
@twillBlockIcon('image')

@include('twill.partials.theme', [
        'types' => [$type],
        'field' => 'pageType',
        'label' => 'Theme',
    ])

<x-twill::select
    name='theme'
    label='Color'
    placeholder='Select color'
    default='1'
    :options="[
        [
            'value' => 1,
            'label' => 'Dark'
        ],
        [
            'value' => 2,
            'label' => 'Light'
        ],
        [
            'value' => 3,
            'label' => 'White'
        ]
    ]"
/>

<x-twill::select
    name='layout'
    label='Layout'
    placeholder='Select layout'
    :options="[
        [
            'value' => 1,
            'label' => 'Layout 1 (Mosaic)'
        ],
        [
            'value' => 2,
            'label' => 'Layout 2 (Carousel)'
        ],
        [
            'value' => 3,
            'label' => 'Layout 3 (Small mosaic)'
        ]
    ]"
/>

<x-twill::formConnectedFields
    field-name='pageType'
    field-values='digitalpublications'
    :render-for-blocks='true'
    :keep-alive='true'
>
    <x-twill::checkbox
        name='hide_figure_number'
        label='Hide figure number'
        default='false'
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='pageType'
    :field-values="['conservation-and-science']"
    :render-for-blocks='true'
    :keep-alive='true'
>
    <x-twill::input
        name='heading'
        label='Heading'
    />
</x-twill::formConnectedFields>

<x-twill::wysiwyg
    name='title'
    label='Title'
    :maxlength='60'
    :toolbar-options="[ 'italic', 'link' ]"
/>

<x-twill::wysiwyg
    name='description'
    label='Description'
    note='Will be hidden if title is empty'
    :maxlength='500'
    :rows='4'
    :toolbar-options="[ 'italic', 'link' ]"
/>

<x-twill::checkbox
    name='disable_gallery_modals'
    label='Disable modals for this gallery'
/>

<x-twill::checkbox
    name='is_gallery_zoomable'
    label='Make all image modals zoomable (override)'
/>

<x-twill::repeater
    type='gallery_new_item'
/>

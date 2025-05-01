@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[5]))->type : null;
    $variations = [
        [
            'value' => '2-wide',
            'label' => '2 wide',
        ],
        [
            'value' => '3-wide',
            'label' => 'Default (3 wide)',
        ],
        [
            'value' => '4-wide',
            'label' => '4 wide',
        ],
    ];
    if ($type === 'Research Center') {
        array_unshift($variations, [
            'value' => '2-wide-combined',
            'label' => '2 wide, combined with Showcase',
        ]);
    }
@endphp

@twillBlockTitle('Grid')
@twillBlockIcon('image')

@include('twill.partials.theme', ['types' => [$type]])

<x-twill::wysiwyg
    name='heading'
    label='Heading'
    :maxlength='60'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::input
    name='grid_link_label'
    label='Link Label'
    note='Displayed at top-right of title bar'
    :maxlength='60'
/>

<x-twill::input
    name='grid_link_href'
    label='Link URL'
    :maxlength='60'
/>

<x-twill::select
    name='variation'
    label='Variation'
    default="3-wide"
    :options="$variations"
/>

<x-twill::repeater
    type="grid_item"
/>

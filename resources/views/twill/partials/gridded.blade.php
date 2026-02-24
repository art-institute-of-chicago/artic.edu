@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[5]))->type : null;
    if ($type == 'Default') {
        $type = null;
    }
@endphp

@include('twill.partials.theme', ['types' => [$type]])


<x-twill::wysiwyg
    name='heading'
    label='Heading'
    :maxlength='60'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::formConnectedFields
    field-name='theme'
    field-values='educator-resources'
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::wysiwyg
        name='description'
        label='Description'
        :toolbar-options="[ 'italic', 'link', 'bold' ]"
    />

</x-twill::formConnectedFields>

<x-twill::select
    name='variation'
    label='Variation'
    default="3-wide"
    :options="[
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
    ]"
/>

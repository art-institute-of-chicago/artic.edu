@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[5]))->type : null;
@endphp

@include('twill.partials.theme', ['types' => [$type], 'includeDefault' => false])

<x-twill::formConnectedFields
    field-name='theme'
    field-values="rlc"
    :render-for-blocks='true'
>

    <x-twill::select
        name='variation'
        label='Variation'
        :options="[
            [
                'value' => 'make-with-us',
                'label' => 'Make with us',
            ],
            [
                'value' => 'experience-with-us',
                'label' => 'Experience with us',
            ],
            [
                'value' => 'learn-with-us',
                'label' => 'Learn with us',
            ]
        ]"
    />

</x-twill::formConnectedFields>

@twillBlockTitle('Showcase Multiple')
@twillBlockIcon('image')

<x-twill::input
    name='heading'
    label='Heading'
/>

<x-twill::input
    name='intro'
    label='Intro'
/>

<x-twill::repeater
    type="showcase_item"
/>

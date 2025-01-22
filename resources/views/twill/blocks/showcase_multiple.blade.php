@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[5]))->type : null;

    switch ($type) {
        case 'RLC':
            $themes = ['rlc'];
            break;
        default:
            $themes = ['default'];
    }

    $options = collect($themes)->map(function($theme) {
        return [
            'value' => $theme,
            'label' => ucfirst($theme),
        ];
    })->toArray();
@endphp

<x-twill::select
    name='theme'
    label='Theme'
    default='default'
    :options="$options"
/>

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => 'rlc',
    'renderForBlocks' => true,
    ])

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

@endcomponent

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

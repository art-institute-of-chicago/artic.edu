@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[5]))->type : null;
    switch ($type) {
        case 'Research Center':
            $pallet = 'research_center';
            break;
        default:
            $pallet = 'general';
    }
    $backgroundColors = collect(config("aic.branding.colors.$pallet"))
        ->mapWithKeys(fn ($hexColor) => [$hexColor => $hexColor]);
@endphp

@twillBlockTitle('Custom Banner')
@twillBlockIcon('image')

@include('twill.partials.theme', ['types' => [$type]])

<x-twill::radios
    name='background_type'
    label='Background Type'
    default='mobile_app'
    :inline='true'
    :options="[
        [
            'value' => 'background_image',
            'label' => 'Image'
        ],
        [
            'value' => 'background_color',
            'label' => 'Color'
        ]
    ]"
/>

<x-twill::formConnectedFields
    field-name='background_type'
    field-values="background_image"
    :render-for-blocks='true'
>

    <x-twill::medias
        name='image'
        label='Image'
        :required='true'
        :max='1'
        :withVideoUrl='false'
    />

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='background_type'
    field-values="background_color"
    :render-for-blocks='true'
>

    @formField('color_select', [
        'name' => 'bgcolor',
        'label' => 'Background color',
        'options' => $backgroundColors,
        'columns' => 3,
    ])

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='theme'
    field-values='research-center'
    :render-for-blocks='true'
    :keep-alive='true'
>
    <x-twill::input
        name='heading'
        label='Heading'
        :required='true'
    />
</x-twill::formConnectedFields>

<x-twill::input
    name='title'
    label='Title'
    :maxlength='100'
    :required='true'
/>

<x-twill::wysiwyg
    name='body'
    label='Body'
    :required='true'
/>

<x-twill::radios
    name='button_type'
    label='Variation'
    default='mobile_app'
    :inline='true'
    :options="[
        [
            'value' => 'mobile_app',
            'label' => 'Mobile App'
        ],
        [
            'value' => 'custom',
            'label' => 'Custom'
        ]
    ]"
/>

<x-twill::formConnectedFields
    field-name='button_type'
    field-values="custom"
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::input
        name='button_text'
        label='Button Text'
        :maxlength='100'
        :required='true'
    />

    <x-twill::input
        name='button_url'
        label='Button URL'
        :maxlength='100'
        :required='true'
    />

    <x-twill::formConnectedFields
        field-name='theme'
        field-values='research-center'
        :render-for-blocks='true'
        :keep-alive='true'
    >
        <x-twill::input
            name='second_button_text'
            label='Second Button Text'
            :maxlength='100'
            :required='true'
        />

        <x-twill::input
            name='second_button_url'
            label='Second Button URL'
            :maxlength='100'
            :required='true'
        />
    </x-twill::formConnectedFields>
</x-twill::formConnectedFields>
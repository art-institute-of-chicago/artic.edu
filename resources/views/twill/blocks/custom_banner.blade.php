@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[5]))->type : null;
    $categoriesList = \App\Models\Category::all()->pluck('name', 'id')->toArray();

    switch ($type) {
        case 'Editorial':
            $themes = ['default', 'editorial'];
            break;
        default:
            $themes = ['default'];
    }
@endphp

@twillBlockTitle('Custom Banner')
@twillBlockIcon('image')

@php
    $options = collect($themes)->map(function($theme) {
        return [
            'value' => $theme,
            'label' => ucfirst($theme),
        ];
    })->toArray()
@endphp

<x-twill::select
    name='theme'
    label='Theme'
    default='default'
    :options="$options"
/>

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => 'editorial',
    'renderForBlocks' => true,
    ])

    <x-twill::select
        name='variation'
        label='Variation'
        :options="[
            [
                'value' => 'cloud',
                'label' => 'Tag cloud'
            ]
        ]"
    />

@endcomponent

    @formConnectedFields([
        'fieldName' => 'variation',
        'fieldValues' => 'cloud',
        'renderForBlocks' => true,
    ])

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

        @formField('multi_select', [
            'name' => 'categories',
            'label' => 'Categories',
            'options' => collect($categoriesList)->map(function($name, $id) {
                return [
                    'value' => $id,
                    'label' => $name,
                ];
            })->toArray(),
            'placeholder' => 'Add categories to the tag cloud',
        ])

        @component('twill::partials.form.utils._columns')
        @slot('left')
            <x-twill::input
                name='link_label'
                label='Link label'
            />
        @endslot

        @slot('right')
            <x-twill::input
                name='link_url'
                label='Link URL'
            />
        @endslot
        @endcomponent

    @endcomponent

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => 'default',
    'renderForBlocks' => true,
    ])

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

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'background_type',
    'fieldValues' => 'background_image',
    'renderForBlocks' => true
])

    @formField('medias', [
        'name' => 'image',
        'label' => 'Image',
        'max' => 1,
        'withVideoUrl' => false,
        'required' => true,
    ])

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'background_type',
    'fieldValues' => 'background_color',
    'renderForBlocks' => true
])

    @formField('color', [
        'name' => 'bgcolor',
        'label' => 'Background color',
        'default' => '#000000'
    ])

@endcomponent


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

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'button_type',
    'fieldValues' => 'custom',
    'renderForBlocks' => true
])

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

@endcomponent

@endcomponent

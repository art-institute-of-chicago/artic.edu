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

@twillBlockTitle('Feature Block')
@twillBlockIcon('image')
@php
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

<x-twill::formConnectedFields
    field-name='theme'
    field-values="editorial"
    :render-for-blocks='true'
>

    <x-twill::select
        name='variation'
        label='Variation'
        :options="[
            [
                'value' => 'default',
                'label' => 'Default',
            ]
        ]"
    />

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='theme'
    field-values="editorial"
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::formConnectedFields
        field-name='variation'
        field-values="default"
        :render-for-blocks='true'
        :keep-alive='true'
    >

        <x-twill::input
            name='heading'
            label='Heading'
            :maxlength='100'
            :required='true'
        />

        <x-twill::wysiwyg
            name='body'
            label='Body'
            type='textarea'
            :required='true'
        />

    </x-twill::formConnectedFields>

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='theme'
    field-values="default"
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::input
        name='feature_heading'
        label='Heading'
    />

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::input
                name='browse_label'
                label='Browse More Label'
            />
        </x-slot>
        <x-slot:right>
            <x-twill::input
                name='browse_link'
                label='Browse More Link'
            />
        </x-slot>
    </x-twill::formColumns>

</x-twill::formConnectedFields>

<x-twill::select
    name='feature_type'
    label='Feature Type'
    default='custom'
    :options="[
        [
            'label' => 'Articles',
            'value' => 'articles',
        ],
        [
            'label' => 'Digital Publications',
            'value' => 'digital_publications',
        ],
        [
            'label' => 'Exhibitions',
            'value' => 'exhibitions',
        ],
        [
            'label' => 'Events',
            'value' => 'events',
        ],
        [
            'label' => 'Interactive Features',
            'value' => 'experiences',
        ],
        [
            'label' => 'Highlights',
            'value' => 'highlights',
        ],
        [
            'label' => 'Videos',
            'value' => 'videos',
        ]
    ]"
/>

<x-twill::radios
    name='image_ratio'
    label='Image Ratio'
    default='square'
    :inline='true'
    :options="[
        [
            'value' => 'square',
            'label' => '1:1'
        ],
        [
            'value' => 'landscape',
            'label' => '16:9'
        ]
    ]"
/>

<x-twill::formConnectedFields
    field-name='feature_type'
    field-values="articles"
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::select
        name='columns'
        label='# of columns'
        note='Number of columns selected and items loaded must match'
        :options="[
            [
                'label' => '2',
                'value' => 2,
            ],
            [
                'label' => '3',
                'value' => 3,
            ],
            [
                'label' => '4',
                'value' => 4,
            ]
        ]"
    />

    <x-twill::browser
        name='articles'
        label='Articles'
        route-prefix='collection.articlesPublications'
        module-name='articles'
        :max='4'
    />

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='feature_type'
    field-values="digital_publications"
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::select
        name='columns'
        label='# of columns'
        note='Number of columns selected and items loaded must match'
        :options="[
            [
                'label' => '2',
                'value' => 2,
            ],
            [
                'label' => '3',
                'value' => 3,
            ],
            [
                'label' => '4',
                'value' => 4,
            ]
        ]"
    />

    <x-twill::browser
        name='digitalPublications'
        label='Digital Publications'
        route-prefix='collection.articlesPublications'
        module-name='digitalPublications'
        :max='4'
    />

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='feature_type'
    field-values="events"
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::checkbox
        name='override_event'
        label='Customize Events'
        :inline='true'
    />

    <x-twill::formConnectedFields
        field-name='override_event'
        :field-values="true"
        :render-for-blocks='true'
    >
        <br/>
        <i>Note: If event date has passed it will not be shown</i>

        <x-twill::browser
            name='events'
            label='Events'
            route-prefix='exhibitionsEvents'
            module-name='events'
            :max='20'
        />

    </x-twill::formConnectedFields>

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='feature_type'
    field-values="exhibitions"
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::select
        name='columns'
        label='# of columns'
        note='Number of columns selected and items loaded must match'
        :options="[
            [
                'label' => '2',
                'value' => 2,
            ],
            [
                'label' => '3',
                'value' => 3,
            ],
            [
                'label' => '4',
                'value' => 4,
            ]
        ]"
    />

    <x-twill::checkbox
        name='override_exhibition'
        label='Customize Exhibitions'
        :inline='true'
    />

    <x-twill::formConnectedFields
        field-name='override_exhibition'
        :field-values="true"
        :render-for-blocks='true'
    >

        <x-twill::browser
            name='exhibitions'
            label='Exhibitions'
            route-prefix='exhibitionsEvents'
            module-name='exhibitions'
            :max='4'
        />

    </x-twill::formConnectedFields>

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='feature_type'
    field-values="experiences"
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::select
        name='columns'
        label='# of columns'
        note='Number of columns selected and items loaded must match'
        :options="[
            [
                'label' => '2',
                'value' => 2,
            ],
            [
                'label' => '3',
                'value' => 3,
            ],
            [
                'label' => '4',
                'value' => 4,
            ]
        ]"
    />

    <x-twill::browser
        name='experiences'
        label='Experiences'
        route-prefix='collection.interactiveFeatures'
        module-name='experiences'
        :max='4'
    />

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='feature_type'
    field-values="highlights"
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::select
        name='columns'
        label='# of columns'
        note='Number of columns selected and items loaded must match'
        :options="[
            [
                'label' => '2',
                'value' => 2,
            ],
            [
                'label' => '3',
                'value' => 3,
            ],
            [
                'label' => '4',
                'value' => 4,
            ]
        ]"
    />

    <x-twill::browser
        name='highlights'
        label='Highlights'
        route-prefix='collection'
        module-name='highlights'
        :max='4'
    />

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='feature_type'
    field-values="videos"
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::select
        name='columns'
        label='# of columns'
        note='Number of columns selected and items loaded must match'
        :options="[
            [
                'label' => '2',
                'value' => 2,
            ],
            [
                'label' => '3',
                'value' => 3,
            ],
            [
                'label' => '4',
                'value' => 4,
            ]
        ]"
    />

    <x-twill::browser
        name='videos'
        label='Videos'
        route-prefix='collection.articlesPublications'
        module-name='videos'
        :max='4'
    />

</x-twill::formConnectedFields>

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
                'value' => 'default',
                'label' => 'Default',
            ]
        ]"
    />

@endcomponent

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => 'editorial',
    'renderForBlocks' => true,
    ])

    @formConnectedFields([
        'fieldName' => 'variation',
        'fieldValues' => 'default',
        'renderForBlocks' => true,
    ])

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

    @endcomponent

@endcomponent

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => 'default',
    'renderForBlocks' => true,
    ])

    <x-twill::input
        name='feature_heading'
        label='Heading'
    />

    @component('twill::partials.form.utils._columns')
        @slot('left')
            <x-twill::input
                name='browse_label'
                label='Browse More Label'
            />
        @endslot
        @slot('right')
            <x-twill::input
                name='browse_link'
                label='Browse More Link'
            />
        @endslot
    @endcomponent

@endcomponent

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

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'articles',
    'renderForBlocks' => true
])

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

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'digital_publications',
    'renderForBlocks' => true
])

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
            ],
        ]
    ])

    <x-twill::browser
        name='digitalPublications'
        label='Digital Publications'
        route-prefix='collection.articlesPublications'
        module-name='digitalPublications'
        :max='4'
    />

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'events',
    'renderForBlocks' => true,
])

    <x-twill::checkbox
        name='override_event'
        label='Customize Events'
        :inline='true'
    />

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'override_event',
        'fieldValues' => true,
        'renderForBlocks' => true,
    ])
        <br/>
        <i>Note: If event date has passed it will not be shown</i>

        <x-twill::browser
            name='events'
            label='Events'
            route-prefix='exhibitionsEvents'
            module-name='events'
            :max='20'
        />

    @endcomponent

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'exhibitions',
    'renderForBlocks' => true,
])

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

    @component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'override_exhibition',
        'fieldValues' => true,
        'renderForBlocks' => true,
    ])

        <x-twill::browser
            name='exhibitions'
            label='Exhibitions'
            route-prefix='exhibitionsEvents'
            module-name='exhibitions'
            :max='4'
        />

    @endcomponent

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'experiences',
    'renderForBlocks' => true
])

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

@endcomponent


@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'highlights',
    'renderForBlocks' => true
])

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

@endcomponent

@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'feature_type',
    'fieldValues' => 'videos',
    'renderForBlocks' => true
])

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

@endcomponent

@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[5]))->type : null;
    $categoriesList = \App\Models\Category::all()->pluck('name', 'id')->toArray();
    $endpoints = [
        [
            'label' => 'Article',
            'value' => moduleRoute('articles', 'collection.articlesPublications', 'browser', ['published' => true]),
        ],
        [
            'label' => 'Highlight',
            'value' => moduleRoute('highlights', 'collection', 'browser', ['is_published' => true])
        ],
        [
            'label' => 'Interactive feature',
            'value' => moduleRoute('experiences', 'collection.interactiveFeatures', 'browser', ['is_published' => true])
        ],
        [
            'label' => 'Video',
            'value' => moduleRoute('videos', 'collection.articlesPublications', 'browser', ['is_published' => true]),
        ],
    ];

    switch ($type) {
        case 'Editorial':
            $themes = ['default'];
            break;
        default:
            $themes = ['default'];
    }
@endphp

@twillBlockTitle('Editorial Block')
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
    field-values="default"
    :render-for-blocks='true'
>

    <x-twill::select
        name='variation'
        label='Variation'
        :options="[
            [
                'value' => 'feature-5-side',
                'label' => 'Feature 5 Side',
            ],
            [
                'value' => 'feature-5-top',
                'label' => 'Feature 5 Top',
            ],
            [
                'value' => 'video',
                'label' => 'Video',
            ],
            [
                'value' => '3-across',
                'label' => '3 Across',
            ],
            [
                'value' => '4-across',
                'label' => '4 Across',
            ]
        ]"
    />

</x-twill::formConnectedFields>

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

<x-twill::formConnectedFields
    field-name='variation'
    field-values="['feature-5-side', 'feature-5-top', '3-across', '4-across']""
    :render-for-blocks='true'
>

    @php
        $options = collect($categoriesList)->map(function($name, $id) {
            return [
                'value' => $id,
                'label' => $name,
            ];
        })->toArray();
    @endphp

    <x-twill::multi-select
        name='categories'
        label='Categories'
        placeholder='Add categories'
        :options="$options"
    />

</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='variation'
    field-values="['feature-5-side', 'feature-5-top']"
    :render-for-blocks='true'
>

    <x-twill::browser
        name='stories'
        label='Stories'
        :max='5'
        :modules='$endpoints'
    />
</x-twill::formConnectedFields>


<x-twill::formConnectedFields
    field-name='variation'
    field-values="video"
    :render-for-blocks='true'
>

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

    <x-twill::browser
        name='videos'
        label='Videos'
        :max='6'
        :modules="[
            [
                'label' => 'Video',
                'value' => moduleRoute('videos', 'collection.articlesPublications', 'browser', ['is_published' => true]),
            ]
        ]"
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='variation'
    field-values="3-across"
    :render-for-blocks='true'
>

    <x-twill::browser
        name='stories'
        label='Stories'
        :max='6'
        :modules='$endpoints'
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='variation'
    field-values="4-across"
    :render-for-blocks='true'
>

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

    <x-twill::browser
        name='stories'
        label='Stories'
        :max='8'
        :modules='$endpoints'
    />
</x-twill::formConnectedFields>

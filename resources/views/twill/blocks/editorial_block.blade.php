@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[5]))->type : null;
    $categoriesList = \App\Models\Category::all()->pluck('name', 'id')->toArray();

    if($type !== 'Publications') {
        $endpoints = [
            [
                'label' => 'Article',
                'value' => '/collection/articlesPublications/articles/browser?published=true&is_published=true'
            ],
            [
                'label' => 'Highlight',
                'value' => '/collection/highlights/browser?published=true&is_published=true'
            ],
            [
                'label' => 'Interactive feature',
                'value' => '/collection/interactiveFeatures/experiences/browser?published=true&is_published=true'
            ],
            [
                'label' => 'Video',
                'value' => '/collection/articlesPublications/videos/browser?published=true&is_published=true'
            ],
        ];
    } else {
        $endpoints = [
            [
                'label' => 'Digital Publications',
                'name' => '/collection/articlesPublications/digitalPublications/browser?published=true&is_published=true'
            ],
            [
                'label' => 'Print Publications',
                'name' => '/collection/articlesPublications/printedPublications/browser?published=true&is_published=true'
            ],
        ];
    }

    $categories = collect($categoriesList)->map(function($name, $id) {
        return [
            'value' => $id,
            'label' => $name,
        ];
    })->values()->toArray();

@endphp

@twillBlockTitle('Editorial Block')
@twillBlockIcon('image')

@include('twill.partials.theme', ['types' => [$type]])

{{-- Default Theme Fields --}}
<x-twill::formConnectedFields
    field-name='theme'
    :field-values="['default', 'conservation-and-science']"
    :render-for-blocks='true'
    :keep-alive='true'
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
            ],
            [
                'value' => '1-and-2',
                'label' => '1 Primary, 2 Secondary',
            ],
        ]"
    />

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

    {{-- Category fields for specific variations --}}
    <x-twill::formConnectedFields
        field-name='variation'
        :field-values="['feature-5-side', 'feature-5-top', '3-across', '4-across']"
        :render-for-blocks='true'
    >
        <x-twill::multi-select
            name='categories'
            label='Categories'
            placeholder='Add categories'
            :options='$categories'
        />
    </x-twill::formConnectedFields>

    {{-- Feature-5 variations browser --}}
    <x-twill::formConnectedFields
        field-name='variation'
        :field-values="['feature-5-side', 'feature-5-top']"
        :render-for-blocks='true'
    >
        <x-twill::browser
            name='stories'
            label="{{ $type == 'Editorial' ? 'Stories' : 'Items' }}"
            :max='5'
            :endpoints='$endpoints'
        />
    </x-twill::formConnectedFields>

    {{-- Video variation fields --}}
    <x-twill::formConnectedFields
        field-name='variation'
        field-values="video"
        :render-for-blocks='true'
        :keep-alive='true'
    >
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

        <x-twill::browser
            name='videos'
            label='Videos'
            :max='6'
            :endpoints="[
                [
                    'label' => 'Video',
                    'value' => '/collection/articlesPublications/videos/browser?published=true&is_published=true'
                ]
            ]"
        />
    </x-twill::formConnectedFields>

    {{-- 3-across variation browser --}}
    <x-twill::formConnectedFields
        field-name='variation'
        field-values="3-across"
        :render-for-blocks='true'
    >
        <x-twill::browser
            name='stories'
            label='Stories'
            :max='6'
            :endpoints='$endpoints'
        />
    </x-twill::formConnectedFields>

    {{-- 4-across variation fields --}}
    <x-twill::formConnectedFields
        field-name='variation'
        field-values="4-across"
        :render-for-blocks='true'
        :keep-alive='true'
    >
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

        <x-twill::browser
            name='stories'
            label='Stories'
            :max='8'
            :endpoints='$endpoints'
        />
    </x-twill::formConnectedFields>

    {{-- 1-and-2 variation fields --}}
    <x-twill::formConnectedFields
        field-name='variation'
        field-values="1-and-2"
        :render-for-blocks='true'
        :keep-alive='true'
    >
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

        <x-twill::browser
            name='stories'
            label='Stories'
            :max='3'
            :endpoints='$endpoints'
        />
    </x-twill::formConnectedFields>
</x-twill::formConnectedFields>

{{-- Publications Theme Fields --}}
<x-twill::formConnectedFields
    field-name='theme'
    field-values="publications"
    :render-for-blocks='true'
    :keep-alive='true'
>
    {{-- Hidden variation field that's pre-selected as feature-5-side and disabled --}}
    <x-twill::select
        name='variation'
        label='Variation'
        default='feature-5-side'
        :options="[
            [
                'value' => 'feature-5-side',
                'label' => 'Feature 5 Side',
            ],
        ]"
    />

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

    {{-- Publications repeater --}}
    <x-twill::repeater
        type='publication_items'
    />
</x-twill::formConnectedFields>

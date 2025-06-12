@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[5]))->type : null;
    switch ($type) {
        case 'Editorial':
            $variations = [
                [
                    'value' => 'default',
                    'label' => 'Default'
                ],
                [
                    'value' => 'categories',
                    'label' => 'Categories'
                ],
            ];

            $categories = \App\Models\Category::orderBy('name')->pluck('name', 'id');

            break;
        case 'Educator Resources':
            $variations = [
                [
                    'value' => 'default',
                    'label' => 'Default'
                ],
                [
                    'value' => 'categories',
                    'label' => 'Categories'
                ],
            ];

            $categories = \App\Models\ResourceCategory::orderBy('name')->pluck('name', 'id');

            break;
        default:
            $variations = [
                [
                    'value' => 'default',
                    'label' => 'Default'
                ],
            ];

            $categories = \App\Models\Category::orderBy('name')->pluck('name', 'id');

            break;
    }
@endphp

@twillBlockTitle('Tag Banner')
@twillBlockIcon('text')

@include('twill.partials.theme', ['types' => [$type]])

<x-twill::select
    name='variation'
    label='Variation'
    :options="$variations"
/>

<x-twill::formConnectedFields
    field-name='variation'
    field-values='default'
    :render-for-blocks='true'
    :keep-alive='true'
>
    <x-twill::repeater
        type='link_tag'
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='variation'
    field-values='categories'
    :render-for-blocks='true'
    :keep-alive='true'
>
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

    <x-twill::multi-select
        name='categories'
        label='Categories'
        placeholder='Add categories to the tag cloud'
        :options="$categories"
    />

    <x-twill::formColumns>
        <x-slot:left>
            <x-twill::input
                name='link_label'
                label='Link label'
                :required='true'
            />
        </x-slot>

        <x-slot:right>
            <x-twill::input
                name='link_url'
                label='Link URL'
                :required='true'
            />
        </x-slot:right>
    </x-twill::formColumns>
</x-twill::formConnectedFields>

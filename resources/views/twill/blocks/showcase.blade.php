@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[5]))->type : null;

    switch ($type) {
        case 'Home':
            $themes = ['default', 'home'];
            $mediaTypes = ['image'];
            break;
        case 'RLC':
            $themes = ['default', 'rlc'];
            $mediaTypes = ['image', 'video'];
            break;
        case 'Publications';
            $themes = ['default', 'publications'];
            $mediaTypes = ['image', 'video'];
            break;
        default:
            $themes = ['default'];
            $mediaTypes = ['image', 'video'];
    }
@endphp

@twillBlockTitle('Showcase')
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
                'value' => 'default',
                'label' => 'Default',
            ],
            [
                'value' => '1e3f49',
                'label' => 'Dark Teal',
            ],
        ]"
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='theme'
    field-values="rlc"
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::select
        name='variation'
        label='Variation'
        :options="[
            [
                'value' => 'default',
                'label' => 'Default',
            ],
            [
                'value' => 'about-the-rlc',
                'label' => 'About the RLC',
            ],
            [
                'value' => 'rlc-secondary',
                'label' => 'RLC secondary (teal)',
            ],
        ]"
    />

    <x-twill::input
        name='heading'
        label='Heading'
    />
</x-twill::formConnectedFields>

<x-twill::formConnectedFields
    field-name='theme'
    field-values="publications"
    :render-for-blocks='true'
    :keep-alive='true'
>

    <x-twill::select
        name='variation'
        label='Variation'
        :options="[
            [
                'value' => 'default',
                'label' => 'Default',
            ],
        ]"
    />

    <x-twill::input
        name='heading'
        label='Heading'
    />
</x-twill::formConnectedFields>

@if (count($mediaTypes) > 1)

    @php
        $options = collect($mediaTypes)->map(function($media) {
                return [
                    'value' => $media,
                    'label' => ucfirst($media),
                ];
            })->toArray();
    @endphp

    <x-twill::select
        name='media_type'
        label='Media Type'
        :required='true'
        :unpack='true'
        :options="$options"
    />

    <x-twill::formConnectedFields
        field-name='media_type'
        field-values="image"
        :render-for-blocks='true'
    >
        <x-twill::medias
            name='image'
            label='Image'
            :max='1'
            :withVideoUrl='false'
            :required='true'
        />
    </x-twill::formConnectedFields>

    <x-twill::formConnectedFields
        field-name='media_type'
        field-values="video"
        :render-for-blocks='true'
    >
        <x-twill::medias
            name='image'
            label='Video'
            :max='1'
            :withVideoUrl='false'
            :required='true'
        />
    </x-twill::formConnectedFields>

@else
    <x-twill::medias
        name='image'
        label='Image'
        :max='1'
        :withVideoUrl='false'
        :required='true'
    />
@endif

<x-twill::input
    name='tag'
    label='Tag'
    :maxlength='100'
/>

<x-twill::wysiwyg
    name='title'
    label='Title'
    :maxlength='100'
    :required='true'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::wysiwyg
    name='description'
    label='Description'
    :required='true'
/>

<x-twill::formConnectedFields
    field-name='theme'
    field-values="rlc"
    :render-for-blocks='true'
>
    <x-twill::input
        name='date'
        label='Date'
    />
</x-twill::formConnectedFields>

<x-twill::formColumns>
    <x-slot:left>
        <x-twill::input
            name='link_label'
            label='Link Label'
        />
    </x-slot:left>
    <x-slot:right>
        <x-twill::input
            name='link_url'
            label='Link Url'
        />
    </x-slot:right>
</x-twill::formColumns>

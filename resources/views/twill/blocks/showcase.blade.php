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

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => 'default',
    'renderForBlocks' => true,
    ])

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
@endcomponent

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
@endcomponent

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

    @formConnectedFields([
        'fieldName' => 'media_type',
        'fieldValues' => 'image',
        'renderForBlocks' => true,
    ])
        <x-twill::medias
            name='image'
            label='Image'
            :max='1'
            :withVideoUrl='false'
            :required='true'
        />
    @endcomponent

    @formConnectedFields([
        'fieldName' => 'media_type',
        'fieldValues' => 'video',
        'renderForBlocks' => true,
    ])
        <x-twill::medias
            name='image'
            label='Video'
            :max='1'
            :withVideoUrl='false'
            :required='true'
        />
    @endcomponent

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

@formConnectedFields([
    'fieldName' => 'theme',
    'fieldValues' => 'rlc',
    'renderForBlocks' => true,
])
    <x-twill::input
        name='date'
        label='Date'
    />
@endcomponent

@component('twill::partials.form.utils._columns')
    @slot('left')
        <x-twill::input
            name='link_label'
            label='Link Label'
        />
    @endslot
    @slot('right')
        <x-twill::input
            name='link_url'
            label='Link Url'
        />
    @endslot
@endcomponent

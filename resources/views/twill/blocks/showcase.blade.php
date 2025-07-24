@php
    $currentUrl = explode('/', request()->url());
    $type = in_array('landingPages', $currentUrl) ? \App\Models\LandingPage::find(intval($currentUrl[5]))->type : null;
    switch ($type) {
        case 'Home':
            $mediaTypes = ['image'];
            break;
        case 'Research Center';
            $mediaTypes = ['image', 'video', 'slideshow'];
            break;
        case 'Conservation and Science';
        case 'Publications';
        case 'RLC':
        default:
            $mediaTypes = ['image', 'video'];
    }
@endphp

@twillBlockTitle('Showcase')
@twillBlockIcon('image')

@include('twill.partials.theme', ['types' => [$type]])

@includeIf('twill.blocks.showcase.' . str($type)->slug())

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
        :keep-alive='true'
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
        :keep-alive='true'
    >
        <x-twill::medias
            name='image'
            label='Video'
            :max='1'
            :withVideoUrl='false'
            :required='true'
        />
    </x-twill::formConnectedFields>

    <x-twill::formConnectedFields
        field-name='media_type'
        field-values='slideshow'
        :render-for-blocks='true'
        :keep-alie='true'
    >
        <x-twill::medias
            name='showcase_slides'
            label='Slides'
            :min='2'
            :max='5'
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

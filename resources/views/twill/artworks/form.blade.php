@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
        ['fieldset' => 'api', 'label' => 'Datahub fields'],
        ['fieldset' => '3dModel', 'label' => '3D Model'],
        ['fieldset' => 'high_res', 'label' => 'Hi-Res'],
    ]
])

@section('contentFields')
    {{-- This section will always be shown --}}
    <p>Artwork content is defined in CITI.</p>

    @if (request()->input('showAIData') === 'true')
      <x-twill::input
          name='semantic_search_description'
          label='Semantic Search Description'
          type='textarea'
      />
    @endif
@stop

@section('fieldsets')

    <x-aic::featuredRelated
        :auto-related="$autoRelated" />

    @include('twill.partials.meta')

    <x-twill::formFieldset id="api" title="Datahub fields">
        <x-twill::input
            name='datahub_id'
            label='Datahub ID'
            disabled='true'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset title="3D Object" id="3dModel">
        <a17-block-aic_3d_model name="aic_3d_model" :thumbnail="false" :caption="false" :browser="false" :cc0="false" />
    </x-twill::formFieldset>

    <x-twill::formFieldset title="Hi-Res" id="high_res">
        <p>This functionality is meant to support super-resolution images. It is a work-around for the 3000-pixel limit on images coming from our DAMS. If you upload an image here, it will replace the primary zoomable image for the artwork on the website.</p>

        <x-twill::medias
            name='iiif'
            label='Custom image'
            note='Minimum image width 3000px'
        />

        <x-twill::checkbox
            name='force_iiif_regenerate'
            label='Force tile regeneration'
            default='false'
        />

        <p>This checkbox is meant as a fail-safe. If for some reason, you see missing tiles when you zoom and pan around the deep-zoom viewer, check this option and re-publish. There's no need to use it under normal circumstances. Please note that it may take up to 10 minutes to generate tiles.</p>
    </x-twill::formFieldset>

    <x-twill::formFieldset id="360file" title="360 File">
        <x-twill::files
            name='image_sequence_file'
            label='Image Sequence Zip'
            note='Upload a .zip file'
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="mirador" title="Mirador">
        <p>Add a Mirador modal to the artwork page by either checking the box below to use the default manifest file or uploading your own.</p>

        @php
            $note = 'i.e. ' . config('api.public_uri') . '/api/v1/artworks/' . $item->datahub_id . '/manifest.json';
        @endphp
        <x-twill::checkbox
            name='default_manifest_url'
            label='Use default manifest file.'
            :note="$note"
            default='false'
        />
        <x-twill::files
            name='upload_manifest_file'
            label='Alternative manifest file'
            note='Upload a .json file'
        />
        <x-twill::radios
            name='default_view'
            label='Default View'
            default='single'
            :inline='true'
            :options="[
                [
                    'value' => 'single',
                    'label' => 'Single'
                ],
                [
                    'value' => 'book',
                    'label' => 'Book'
                ]
            ]"
        />
    </x-twill::formFieldset>

    <x-twill::formFieldset id="website" title="Artwork website">
        <p>When the work of art is itself a website, enter its information here.</p>
        <x-twill::input
            name='artwork_website_url'
            label='Artwork website URL'
        />
    </x-twill::formFieldset>
@stop

@push('vuexStore')
    @php($model3d = $item->model3d)
    @foreach (['model_url', 'model_caption', 'model_id', 'camera_position', 'camera_target', 'annotation_list'] as $name)
        window['{{ config('twill.js_namespace') }}'].STORE.form.fields.push({
            name: "{{ 'aic_3d_model[' . $name . ']' }}",
            value: {!! json_encode($model3d ? $model3d->$name : '') !!}
        })
    @endforeach
@endpush

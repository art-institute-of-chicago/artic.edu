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
@stop

@section('fieldsets')
    @component('admin.partials.featured-related', ['form_fields' => $form_fields])
        @slot('routePrefix', 'collection')
        @slot('moduleName', 'artworks')
    @endcomponent

    @include('admin.partials.meta')

    <a17-fieldset id="api" title="Datahub fields">
        @formField('input', [
            'name' => 'datahub_id',
            'label' => 'Datahub ID',
            'disabled' => true
        ])
    </a17-fieldset>

    <a17-fieldset title="3D Object" id="3dModel">
        <a17-block-aic_3d_model name="aic_3d_model" :thumbnail="false" :caption="false" :browser="false" :cc0="false" />
    </a17-fieldset>

    <a17-fieldset title="Hi-Res" id="high_res">
        <p>This functionality is meant to support super-resolution images. It is a work-around for the 3000-pixel limit on images coming from our DAMS. If you upload an image here, it will replace the primary zoomable image for the artwork on the website.</p>

        @formField('medias', [
            'with_multiple' => false,
            'no_crop' => true,
            'label' => 'Custom image',
            'name' => 'iiif',
            'note' => 'Minimum image width 3000px'
        ])

        @formField('checkbox', [
            'name' => 'force_iiif_regenerate',
            'label' => 'Force tile regeneration',
            'default' => false,
        ])

        <p>This checkbox is meant as a fail-safe. If for some reason, you see missing tiles when you zoom and pan around the deep-zoom viewer, check this option and re-publish. There's no need to use it under normal circumstances. Please note that it may take up to 10 minutes to generate tiles.</p>
    </a17-fieldset>

    <a17-fieldset id="360file" title="360 File">
        @formField('files', [
            'name' => 'image_sequence_file',
            'label' => 'Image Sequence Zip',
            'note' => 'Upload a .zip file'
        ])
    </a17-fieldset>

    <a17-fieldset id="mirador" title="Mirador">
        <p>Add a Mirador modal to the artwork page by either checking the box below to use the default manifest file or uploading your own.</p>
        @formField('checkbox', [
            'name' => 'default_manifest_url',
            'label' => 'Use default manifest file.',
            'note' => 'i.e. ' . config('api.public_uri') . '/api/v1/artworks/' . $item->datahub_id . '/manifest.json',
            'default' => false,
        ])
        @formField('files', [
            'name' => 'upload_manifest_file',
            'label' => 'Alternative manifest file',
            'note' => 'Upload a .json file'
        ])
        @formField('radios', [
            'name' => 'default_view',
            'label' => 'Default View',
            'default' => 'single',
            'inline' => true,
            'options' => [
                [
                    'value' => 'single',
                    'label' => 'Single'
                ],
                [
                    'value' => 'book',
                    'label' => 'Book'
                ],
            ]
        ])
    </a17-fieldset>

    <a17-fieldset id="website" title="Artwork website">
        <p>When the work of art is itself a website, enter its information here.</p>
        @formField('input', [
            'name' => 'artwork_website_url',
            'label' => 'Artwork website URL',
        ])
    </a17-fieldset>
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

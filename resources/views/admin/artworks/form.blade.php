@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related'],
        ['fieldset' => 'metadata', 'label' => 'Metadata'],
        ['fieldset' => 'api', 'label' => 'Datahub fields'],
    ]
])

@section('contentFields')
    {{-- Nothing to see here yet. This section will always be shown --}}
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
        <a17-block-aic_3d_model name="aic_3d_model" :thumbnail="true" :caption="true" :browser="false"/>
    </a17-fieldset>
@stop

@push('vuexStore')
    @php($aic3DModel = $item->AIC3DModel)
    @foreach (['model_url', 'model_caption', 'model_id', 'camera_position', 'camera_target', 'annotation_list'] as $name)
        window.STORE.form.fields.push({
            name: "{{ 'aic_3d_model[' . $name . ']' }}",
            value: {!! json_encode($aic3DModel ? $aic3DModel->$name : '') !!}
        })
    @endforeach
@endpush
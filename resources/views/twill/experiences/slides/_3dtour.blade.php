<x-twill::formConnectedFields
    field-name='module_type'
    field-values="3dtour"
    :keep-alive='true'
>
    <a17-block-aic_3d_model name="aic_3d_model" :thumbnail="false" :caption="false" :browser="false" :cc0="false" :optional-annotation="true" :optional-annotation-title="true"/>
</x-twill::formConnectedFields>

@push('vuexStore')
    @php($model3d = $item->model3d)
    @foreach (['model_url', 'model_caption_title', 'model_caption', 'model_id', 'camera_position', 'camera_target', 'annotation_list', 'hide_annotation', 'hide_annotation_title', 'guided_tour'] as $name)
        window['{{ config('twill.js_namespace') }}'].STORE.form.fields.push({
            name: "{{ 'aic_3d_model[' . $name . ']' }}",
            value: {!! json_encode($model3d ? $model3d->$name : '') !!}
        })
    @endforeach
@endpush

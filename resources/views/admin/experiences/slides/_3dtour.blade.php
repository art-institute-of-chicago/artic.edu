@component('twill::partials.form.utils._connected_fields', [
    'fieldName' => 'module_type',
    'fieldValues' => '3dtour',
    'keepAlive' => true,
])
    @php($aic3dModel = $item->AIC3DModel)
    <a17-block-aic_3d_model
        name="aic_3d_model"
        :model-id="{{ json_encode($aic3dModel ? $aic3dModel->model_id : '') }}"
        :camera-position="{{ json_encode($aic3dModel ? $aic3dModel->getOriginal('camera_position') : '') }}"
        :camera-target="{{ json_encode($aic3dModel ? $aic3dModel->getOriginal('camera_target') : '') }}"
        :annotation-list="{{ json_encode($aic3dModel ? $aic3dModel->getOriginal('annotation_list') : '') }}"
    />
@endcomponent
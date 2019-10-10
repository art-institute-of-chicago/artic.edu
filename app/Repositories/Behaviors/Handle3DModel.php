<?php

namespace App\Repositories\Behaviors;

use App\Models\AIC3DModel;

trait Handle3DModel
{
    private function handle3DModel($object, $fields)
    {
        if (!empty($fields['aic_3d_model[model_url]']) 
            && !empty($fields['aic_3d_model[model_id]'])
            && !empty($fields['aic_3d_model[camera_position]'])
            && !empty($fields['aic_3d_model[camera_target]'])
            && !empty($fields['aic_3d_model[annotation_list]'])
        ) {
            $model = AIC3DModel::updateOrCreate(
                [
                    'model_id' => $fields['aic_3d_model[model_id]']
                ],
                [
                    'model_url' => $fields['aic_3d_model[model_url]'],
                    'model_id' => $fields['aic_3d_model[model_id]'],
                    'camera_position' => $fields['aic_3d_model[camera_position]'],
                    'camera_target' => $fields['aic_3d_model[camera_target]'],
                    'annotation_list' => $fields['aic_3d_model[annotation_list]'],
                ]
            );
            $object->AIC3DModel()->associate($model);
            $object->save();
        }
    }

    private function getFormFieldsFor3DModel($object, $fields)
    {
        $aic3dModel = $object->AIC3DModel;
        if ($aic3dModel) {
            $fields['aic_3d_model[model_id]'] = $aic3dModel->model_id;
            $fields['aic_3d_model[camera_position]'] = $aic3dModel->getOriginal('camera_position');
            $fields['aic_3d_model[camera_target]'] = $aic3dModel->getOriginal('camera_target');
            $fields['aic_3d_model[annotation_list]'] = $aic3dModel->getOriginal('annotation_list');
        };
        return $fields;
    }
}

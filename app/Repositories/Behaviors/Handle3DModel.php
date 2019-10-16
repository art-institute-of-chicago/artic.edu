<?php

namespace App\Repositories\Behaviors;

use App\Models\AIC3DModel;

trait Handle3DModel
{
    private function handle3DModel($object, $fields, $fieldName = 'aic_3d_model')
    {
        if (!empty($fields["{$fieldName}[model_url]"]) 
            && !empty($fields["{$fieldName}[model_id]"])
            && !empty($fields["{$fieldName}[camera_position]"])
            && !empty($fields["{$fieldName}[camera_target]"])
            && !empty($fields["{$fieldName}[annotation_list]"])
        ) {
            $model = AIC3DModel::updateOrCreate(
                [
                    'model_id' => $fields["{$fieldName}[model_id]"]
                ],
                [
                    'model_url' => $fields["{$fieldName}[model_url]"],
                    'model_id' => $fields["{$fieldName}[model_id]"],
                    'camera_position' => $fields["{$fieldName}[camera_position]"],
                    'camera_target' => $fields["{$fieldName}[camera_target]"],
                    'annotation_list' => $fields["{$fieldName}[annotation_list]"],
                ]
            );
            $object->AIC3DModel()->associate($model);
            $object->save();
        }
    }

    private function getFormFieldsFor3DModel($object, $fields, $fieldName = 'aic_3d_model')
    {
        $aic3dModel = $object->AIC3DModel;
        if ($aic3dModel) {
            $fields["{$fieldName}[model_id]"] = $aic3dModel->model_id;
            $fields["{$fieldName}[camera_position]"] = $aic3dModel->getOriginal('camera_position');
            $fields["{$fieldName}[camera_target]"] = $aic3dModel->getOriginal('camera_target');
            $fields["{$fieldName}[annotation_list]"] = $aic3dModel->getOriginal('annotation_list');

            // Render the 3d model field in repeater block
            if ($object instanceOf \App\Models\Slide &&
                $object->secondaryExperienceModal->first() &&
                $aic3dModel = $object->secondaryExperienceModal->first()->AIC3DModel)
            {
                $secondaryExperienceModal = $object->secondaryExperienceModal->first();
                $aic3dFields = ['model_url', 'model_id', 'camera_position', 'camera_target', 'annotation_list'];
                foreach ($aic3dFields as $aic3dField) {
                    array_push($fields['repeaterFields']['secondary_experience_modal'], [
                        'name' => "blocks[secondaryExperienceModal-{$secondaryExperienceModal->id}][aic_split_3d_model][{$aic3dField}]",
                        'value' => $aic3dModel->$aic3dField
                    ]);
                }        
            }
        };
        return $fields;
    }
}

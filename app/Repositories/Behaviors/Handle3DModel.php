<?php

namespace App\Repositories\Behaviors;

use App\Models\AIC3DModel;
use A17\Twill\Models\Media;
use Illuminate\Support\Arr;

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
                    'model_caption' => isset($fields["{$fieldName}[model_caption]"]) ? $fields["{$fieldName}[model_caption]"] : '',
                    'camera_position' => $fields["{$fieldName}[camera_position]"],
                    'camera_target' => $fields["{$fieldName}[camera_target]"],
                    'annotation_list' => $fields["{$fieldName}[annotation_list]"]
                ]
            );
            $object->AIC3DModel()->associate($model);
            $object->save();

            $this->handle3DModelThumbnail($object, $fields, $model);
        }
    }

    private function getFormFieldsFor3DModel($object, $fields, $fieldName = 'aic_3d_model')
    {
        $aic3dModel = $object->AIC3DModel;
        if ($aic3dModel) {
            $fields["{$fieldName}[model_id]"] = $aic3dModel->model_id;
            $fields["{$fieldName}[model_caption]"] = $aic3dModel->getOriginal('model_caption');
            $fields["{$fieldName}[camera_position]"] = $aic3dModel->getOriginal('camera_position');
            $fields["{$fieldName}[camera_target]"] = $aic3dModel->getOriginal('camera_target');
            $fields["{$fieldName}[annotation_list]"] = $aic3dModel->getOriginal('annotation_list');
            
            // Render the 3d model field in repeater block
            if ($object instanceOf \App\Models\Slide &&
            $object->secondaryExperienceModal->first() &&
            $aic3dModel = $object->secondaryExperienceModal->first()->AIC3DModel)
            {
                $secondaryExperienceModal = $object->secondaryExperienceModal->first();
                $aic3dFields = ['model_url', 'model_id', 'model_caption', 'camera_position', 'camera_target', 'annotation_list'];
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

    private function handle3DModelThumbnail($object, $fields, $aic3dModel) {
        // if (isset($fields['medias']['aic_3d_model[image]'][0])) {
        //     $media = $fields['medias']['aic_3d_model[image]'][0];
        //     $newMedia = Media::withTrashed()->find(is_array($media['id']) ? Arr::first($media['id']) : $media['id']);
        //     $pivot = $newMedia->newPivot($aic3dModel, Arr::except($media, ['id']), 'mediables', true);
        //     $newMedia->setRelation('pivot', $pivot);
        // }
    }
}

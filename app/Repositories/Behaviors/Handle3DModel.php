<?php

namespace App\Repositories\Behaviors;

use App\Models\Model3d;

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
            $model = Model3d::updateOrCreate(
                [
                    'model_id' => $fields["{$fieldName}[model_id]"]
                ],
                [
                    'model_url' => $fields["{$fieldName}[model_url]"],
                    'model_id' => $fields["{$fieldName}[model_id]"],
                    'model_caption_title' => $fields["{$fieldName}[model_caption_title]"] ?? '',
                    'model_caption' => $fields["{$fieldName}[model_caption]"] ?? '',
                    'camera_position' => $fields["{$fieldName}[camera_position]"],
                    'camera_target' => $fields["{$fieldName}[camera_target]"],
                    'annotation_list' => $fields["{$fieldName}[annotation_list]"],
                    'guided_tour' => $fields["{$fieldName}[guided_tour]"] ?? false,
                    'hide_annotation' => empty($fields["{$fieldName}[hide_annotation]"]) ? false : $fields["{$fieldName}[hide_annotation]"],
                    'hide_annotation_title' => empty($fields["{$fieldName}[hide_annotation_title]"]) ? false : $fields["{$fieldName}[hide_annotation_title]"],
                ]
            );
            $object->model3d()->associate($model);
            $object->save();
        }
    }

    private function getFormFieldsFor3DModel($object, $fields, $fieldName = 'aic_3d_model')
    {
        // Render the 3d model field in repeater block
        if ($object instanceof \App\Models\Slide &&
        $object->secondaryExperienceModal->first() &&
        $model3d = $object->secondaryExperienceModal->first()->model3d) {
            $secondaryExperienceModal = $object->secondaryExperienceModal->first();
            $aic3dFields = ['model_url', 'model_id', 'model_caption_title', 'model_caption', 'camera_position', 'guided_tour', 'camera_target', 'annotation_list', 'hide_annotation', 'hide_annotation_title'];
            foreach ($aic3dFields as $aic3dField) {
                array_push($fields['repeaterFields']['secondary_experience_modal'], [
                    'name' => "blocks[secondaryExperienceModal-{$secondaryExperienceModal->id}][aic_split_3d_model][{$aic3dField}]",
                    'value' => $model3d->{$aic3dField}
                ]);
            }
        }

        $model3d = $object->model3d;
        if ($model3d) {
            $fields["{$fieldName}[model_id]"] = $model3d->model_id;
            $fields["{$fieldName}[model_caption_title]"] = $model3d->getOriginal('model_caption_title');
            $fields["{$fieldName}[model_caption]"] = $model3d->getOriginal('model_caption');
            $fields["{$fieldName}[guided_tour]"] = $model3d->getOriginal('guided_tour');
            $fields["{$fieldName}[camera_position]"] = $model3d->getOriginal('camera_position');
            $fields["{$fieldName}[camera_target]"] = $model3d->getOriginal('camera_target');
            $fields["{$fieldName}[annotation_list]"] = $model3d->getOriginal('annotation_list');
            $fields["{$fieldName}[hide_annotation]"] = $model3d->getOriginal('hide_annotation');
            $fields["{$fieldName}[hide_annotation_title]"] = $model3d->getOriginal('hide_annotation_title');
        }

        return $fields;
    }
}

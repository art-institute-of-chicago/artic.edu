<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\ExperienceModal;
use Carbon\Carbon;

class ExperienceModalRepository extends ModuleRepository
{
    use HandleBlocks, HandleMedias, HandleFiles, HandleRevisions;

    public function __construct(ExperienceModal $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateRepeater($object, $fields, 'experienceImage', 'ExperienceImage', 'modal_experience_image');
        parent::afterSave($object, $fields);
}

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        // $fields = $this->getFormFieldsForRepeater($object, $fields, 'experienceImage', 'ExperienceImage', 'modal_experience_image');
        // $fields['blocks'] = $fields['repeaters'];
        return $fields;
    }

    public function prepareFieldsBeforeCreate($fields)
    {
        if (isset($fields['blocks']) && !is_null($fields['blocks'])) {
            $fields['repeaters'] = $fields['blocks'];
            unset($fields['blocks']);
        };

        if (isset($fields['video_play_settings'])) {
            $fields['video_play_settings'] = json_encode($fields['video_play_settings']);
        }

        if (isset($fields['image_sequence_playback'])) {
            $fields['image_sequence_playback'] = json_encode($fields['image_sequence_playback']);
        }

        return parent::prepareFieldsBeforeCreate($fields);
    }

    public function updateRepeater($object, $fields, $relation, $model = null, $repeaterName = null)
    {
        if (!$repeaterName) {
            $repeaterName = $relation;
        }

        $relationFields = $fields['repeaters'][$repeaterName] ?? [];

        $relationRepository = $this->getModelRepository($relation, $model);

        // if no relation field submitted, soft deletes all associated rows
        if (!$relationFields) {
            $relationRepository->updateBasic(null, [
                'deleted_at' => Carbon::now(),
            ], [
                'imagable_type' => get_class($object),
                'imagable_id' => $object->id,
                'imagable_repeater_name' => 'modal_experience_image',
            ]);
        }

        // keep a list of updated and new rows to delete (soft delete?) old rows that were deleted from the frontend
        $currentIdList = [];

        foreach ($relationFields as $index => $experienceImageBlock) {
            $relationField = $experienceImageBlock['content'];
            $relationField['position'] = $index + 1;
            if (isset($relationField['id']) && starts_with($relationField['id'], $relation)) {
                // row already exists, let's update
                $id = str_replace($relation . '-', '', $relationField['id']);
                $relationRepository->update($id, $relationField);
                $currentIdList[] = $id;
            } else {
                // new row, let's attach to our object and create
                $relationField['imagable_type'] = get_class($object);
                $relationField['imagable_id'] = $object->id;
                $relationField['imagable_repeater_name'] = 'modal_experience_image';
                unset($relationField['id']);
                $newRelation = $relationRepository->create($relationField);
                $currentIdList[] = $newRelation['id'];
            }
        }

        foreach ($object->$relation->pluck('id') as $id) {
            if (!in_array($id, $currentIdList)) {
                $relationRepository->updateBasic(null, [
                    'deleted_at' => Carbon::now(),
                ], [
                    'id' => $id,
                ]);
            }
        }
    }

    public function getFormFieldsForRepeater($object, $fields, $relation, $model = null, $repeaterName = null)
    {
        if (!$repeaterName) {
            $repeaterName = $relation;
        }
        
        $repeaters = [];
        $repeatersFields = [];
        $repeatersBrowsers = [];
        $repeatersMedias = [];
        $repeatersFiles = [];
        $relationRepository = $this->getModelRepository($relation, $model);
        $repeatersConfig = config('twill.block_editor.repeaters');

        foreach ($object->$relation as $relationItem) {
            $repeaters[] = [
                'id' => $relation . '-' . $relationItem->id,
                'type' => $repeatersConfig[$repeaterName]['component'],
                'title' => $repeatersConfig[$repeaterName]['title'],
            ];

            $relatedItemFormFields = $relationRepository->getFormFields($relationItem);
            $translatedFields = [];

            if (isset($relatedItemFormFields['translations'])) {
                foreach ($relatedItemFormFields['translations'] as $key => $values) {
                    $repeatersFields[] = [
                        'name' => "blocks[$relation-$relationItem->id][$key]",
                        'value' => $values,
                    ];

                    $translatedFields[] = $key;
                }
            }

            if (isset($relatedItemFormFields['medias'])) {
                foreach ($relatedItemFormFields['medias'] as $key => $values) {
                    $repeatersMedias["blocks[$relation-$relationItem->id][$key]"] = $values;
                }
            }

            if (isset($relatedItemFormFields['files'])) {
                $repeatersFiles = [];

                collect($relatedItemFormFields['files'])->each(function ($rolesWithFiles, $locale) use (&$repeatersFiles, $relation, $relationItem) {
                    $repeatersFiles[] = collect($rolesWithFiles)->mapWithKeys(function ($files, $role) use ($locale, $relation, $relationItem) {
                        return [
                            "blocks[$relation-$relationItem->id][$role][$locale]" => $files,
                        ];
                    })->toArray();
                });

                $repeatersFiles = call_user_func_array('array_merge', $repeatersFiles);
            }

            if (isset($relatedItemFormFields['browsers'])) {
                foreach ($relatedItemFormFields['browsers'] as $key => $values) {
                    $repeatersBrowsers["blocks[$relation-$relationItem->id][$key]"] = $values;
                }
            }

            $itemFields = method_exists($relationItem, 'toRepeaterArray') ? $relationItem->toRepeaterArray() : array_except($relationItem->attributesToArray(), $translatedFields);


            foreach ($itemFields as $key => $value) {
                $repeatersFields[] = [
                    'name' => "blocks[$relation-$relationItem->id][$key]",
                    'value' => $value,
                ];
            }

        }

        $fields['repeaters'][$repeaterName] = $repeaters;

        $fields['repeaterFields'][$repeaterName] = $repeatersFields;

        $fields['repeaterMedias'][$repeaterName] = $repeatersMedias;

        $fields['repeaterFiles'][$repeaterName] = $repeatersFiles;

        $fields['repeaterBrowsers'][$repeaterName] = $repeatersBrowsers;
        return $fields;

    }

}

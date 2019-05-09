<?php

namespace App\Repositories\Behaviors;

use Carbon\Carbon;

trait HandleExperienceModule
{
    public function updateExperienceModule($object, $fields, $relation, $model = null, $fieldName = null)
    {
        if ($model === 'ExperienceImage') {
            $morphKey = 'imagable';
        } else {
            $morphKey = 'modalble';
        }

        $fieldName = $fieldName ?? $relation;
        $relationFields = $fields['repeaters'][$fieldName] ?? [];
        
        $relationRepository = $this->getModelRepository($relation, $model);
        
        // if no relation field submitted, soft deletes all associated rows
        if (!$relationFields) {
            $relationRepository->updateBasic(null, [
                'deleted_at' => Carbon::now(),
            ], [
                $morphKey . '_type' => get_class($object),
                $morphKey . '_id' => $object->id,
                $morphKey . '_repeater_name' => $fieldName,
                ]);
            }
            
        // keep a list of updated and new rows to delete (soft delete?) old rows that were deleted from the frontend
        $currentIdList = [];

        foreach ($relationFields as $index => $relationField) {
            $relationField['position'] = $index + 1;
            if (isset($relationField['id']) && starts_with($relationField['id'], $relation)) {
                // row already exists, let's update
                $id = str_replace($relation . '-', '', $relationField['id']);
                $relationRepository->update($id, $relationField);
                $currentIdList[] = $id;
            } else {
                // new row, let's attach to our object and create
                $relationField[$morphKey . '_type'] = get_class($object);
                $relationField[$morphKey . '_id'] = $object->id;
                $relationField[$morphKey . '_repeater_name'] = $fieldName;
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

    public function getExperienceModule($object, $fields, $relation, $model = null, $fieldName = null)
    {
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
                'type' => $repeatersConfig[$fieldName]['component'],
                'title' => $repeatersConfig[$fieldName]['title'],
            ];

            // if ($model === 'ExperienceModal') {
            //     foreach ($relationItem->experienceImage as $relationItem) {
            //         $repeaters[] = [
            //             'id' => 'modalExperienceImage-' . $relationItem->id,
            //             'type' => $repeatersConfig['modal_experience_image']['component'],
            //             'title' => $repeatersConfig['modal_experience_image']['title'],
            //         ];
            //     }
            // }
            
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

        $fields['repeaters'][$fieldName] = $repeaters;

        $fields['repeaterFields'][$fieldName] = $repeatersFields;

        $fields['repeaterMedias'][$fieldName] = $repeatersMedias;

        $fields['repeaterFiles'][$fieldName] = $repeatersFiles;

        $fields['repeaterBrowsers'][$fieldName] = $repeatersBrowsers;

        return $fields;

    }
}

<?php

namespace App\Repositories\Behaviors;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Carbon\Carbon;
use A17\Twill\Services\Blocks\BlockCollection;

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

        // If no relation field submitted, soft deletes all associated rows
        if (!$relationFields) {
            $relationRepository->updateBasic(null, [
                'deleted_at' => Carbon::now(),
            ], [
                $morphKey . '_type' => get_class($object),
                $morphKey . '_id' => $object->id,
                $morphKey . '_repeater_name' => $fieldName,
            ]);
        }

        // Keep a list of updated and new rows to delete (soft delete?) old rows that were deleted from the frontend
        $currentIdList = [];

        foreach ($relationFields as $index => $relationField) {
            if (isset($relationField['id']) && Str::startsWith($relationField['id'], $relation)) {
                // Row already exists, let's update
                $id = str_replace($relation . '-', '', $relationField['id']);
                if ($fieldName === 'modal_experience_image') {
                    $medias = $relationField['medias'];
                    $relationField = $relationField['content'];
                    $relationField['medias'] = $medias;
                }
                $relationRepository->update($id, $relationField);
                $currentIdList[] = $id;
            } else {
                // New row, let's attach to our object and create
                unset($relationField['id']);
                if ($fieldName === 'modal_experience_image') {
                    $medias = $relationField['medias'];
                    $relationField = $relationField['content'];
                    $relationField['medias'] = $medias;
                }
                $relationField[$morphKey . '_type'] = get_class($object);
                $relationField[$morphKey . '_id'] = $object->id;
                $relationField[$morphKey . '_repeater_name'] = $fieldName;
                $newRelation = $relationRepository->create($relationField);
                $currentIdList[] = $newRelation['id'];
            }
        }

        foreach ($object->{$relation}->pluck('id') as $id) {
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
        $repeatersConfig = app(BlockCollection::class)->getRepeaters();

        foreach ($object->{$relation} as $relationItem) {
            $rep = $repeatersConfig->first(function (\A17\Twill\Services\Blocks\Block $block) use ($fieldName) {
                return $block->name == $fieldName;
            });

            $repeaters[] = [
                'id' => $relation . '-' . $relationItem->id,
                'type' => $rep->component,
                'title' => $rep->title,
            ];

            $relatedItemFormFields = $relationRepository->getFormFields($relationItem);
            $translatedFields = [];

            if (isset($relatedItemFormFields['translations'])) {
                foreach ($relatedItemFormFields['translations'] as $key => $values) {
                    $repeatersFields[] = [
                        'name' => "blocks[${relation}-{$relationItem->id}][${key}]",
                        'value' => $values,
                    ];

                    $translatedFields[] = $key;
                }
            }

            if (isset($relatedItemFormFields['medias'])) {
                foreach ($relatedItemFormFields['medias'] as $key => $values) {
                    $repeatersMedias["blocks[${relation}-{$relationItem->id}][${key}]"] = $values;
                }
            }

            if (isset($relatedItemFormFields['files'])) {
                $repeatersFiles = [];

                collect($relatedItemFormFields['files'])->each(function ($rolesWithFiles, $locale) use (&$repeatersFiles, $relation, $relationItem) {
                    $repeatersFiles[] = collect($rolesWithFiles)->mapWithKeys(function ($files, $role) use ($locale, $relation, $relationItem) {
                        return [
                            "blocks[${relation}-{$relationItem->id}][${role}][${locale}]" => $files,
                        ];
                    })->toArray();
                });

                $repeatersFiles = call_user_func_array('array_merge', $repeatersFiles);
            }

            if (isset($relatedItemFormFields['browsers'])) {
                foreach ($relatedItemFormFields['browsers'] as $key => $values) {
                    $repeatersBrowsers["blocks[${relation}-{$relationItem->id}][${key}]"] = $values;
                }
            }

            $itemFields = method_exists($relationItem, 'toRepeaterArray') ? $relationItem->toRepeaterArray() : Arr::except($relationItem->attributesToArray(), $translatedFields);

            if ($model === 'ExperienceModal') {
                $modal_name = $relation . '-' . $relationItem->id;
                foreach ($relationItem->experienceImage->toArray() as $experienceImage) {
                    $experienceImageRepository = app('App\Repositories\ExperienceImageRepository');
                    $experienceImageFormFields = $experienceImageRepository->getFormFields($experienceImageRepository->getById($experienceImage['id']));
                    if (isset($experienceImageFormFields['medias'])) {
                        $fields['repeaterMedias']['modal_experience_image']['blocks[experienceImage-' . $experienceImage['id'] . '][experience_image]'] = $experienceImageFormFields['medias']['experience_image'];
                    }
                    foreach ($experienceImage as $field => $value) {
                        $fields['repeaterFields']['modal_experience_image'][] = [
                            'name' => 'blocks[experienceImage-' . $experienceImage['id'] . '][' . $field . ']',
                            'value' => $value
                        ];
                    }
                }

                $rep = $repeatersConfig->first(function (\A17\Twill\Services\Blocks\Block $block) use ($fieldName) {
                    return $block->name == 'modal_experience_image';
                });

                $fields['repeaters']['blocks-' . $modal_name . '_modal_experience_image'] = $relationItem->experienceImage->map(function ($experienceImage) use ($rep) {
                    return [
                        'id' => 'experienceImage-' . $experienceImage->id,
                        'type' => $rep->component,
                        'title' => $rep->title,
                    ];
                });
            }

            foreach ($itemFields as $key => $value) {
                $repeatersFields[] = [
                    'name' => "blocks[${relation}-{$relationItem->id}][${key}]",
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

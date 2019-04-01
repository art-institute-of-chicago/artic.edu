<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRepeaters;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\Behaviors\HandleTranslations;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Experience;
use Carbon\Carbon;

class ExperienceRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions, HandleRepeaters;

    public function __construct(Experience $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateExperienceImage($object, $fields, 'attractExperienceImages', 'ExperienceImage', 'attract_experience_image');
        $this->updateExperienceImage($object, $fields, 'endBackgroundExperienceImages', 'ExperienceImage', 'end_bg_experience_image');
        $this->updateExperienceImage($object, $fields, 'endExperienceImages', 'ExperienceImage', 'end_experience_image');
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getExperienceImage($object, $fields, 'attractExperienceImages', 'ExperienceImage', 'attract_experience_image');
        $fields = $this->getExperienceImage($object, $fields, 'endBackgroundExperienceImages', 'ExperienceImage', 'end_bg_experience_image');
        $fields = $this->getExperienceImage($object, $fields, 'endExperienceImages', 'ExperienceImage', 'end_experience_image');
        return $fields;
    }

    public function updateExperienceImage($object, $fields, $relation, $model = null, $fieldName = null)
    {
        $fieldName = $fieldName ?? $relation;
        $relationFields = $fields['repeaters'][$fieldName] ?? [];

        $relationRepository = $this->getModelRepository($relation, $model);

        // if no relation field submitted, soft deletes all associated rows
        if (!$relationFields) {
            $relationRepository->updateBasic(null, [
                'deleted_at' => Carbon::now(),
            ], [
                'imagable_type' => get_class($object),
                'imagable_id' => $object->id,
                'imagable_repeater_name' => $fieldName,
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
                $relationField['imagable_type'] = get_class($object);
                $relationField['imagable_id'] = $object->id;
                $relationField['imagable_repeater_name'] = $fieldName;
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

    public function getExperienceImage($object, $fields, $relation, $model = null, $fieldName = null)
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

    public function getCountByStatusSlug($slug, $scope = [])
    {
        $scope = $scope + ['archived' => false];
        return parent::getCountByStatusSlug($slug, $scope);
    }
}

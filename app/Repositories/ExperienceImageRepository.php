<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use App\Models\Api\Artwork;
use App\Models\ExperienceImage;

class ExperienceImageRepository extends ModuleRepository
{
    use HandleBlocks, HandleMedias, HandleFiles, HandleRevisions;

    public function __construct(ExperienceImage $model)
    {
        $this->model = $model;
    }

    public function updateFieldsFromApi($fields)
    {
        $credits_map = [
            'artist' => 'artist_title',
            'credit_title' => 'title',
            'credit_date' => 'date_start',
            'medium' => 'medium_display',
            'dimensions' => 'dimensions',
            'credit_line' => 'credit_line',
            'main_reference_number' => 'main_reference_number',
            'copyright_notice' => 'copyright_notice',
        ];

        $object_id = $fields['object_id'] ?? null;
        $apiResult = Artwork::query()->find($object_id);

        if ($object_id && $apiResult instanceof Artwork) {
            $artwork = $apiResult->toArray();
            foreach ($credits_map as $contentBundleKey => $artworkKey) {
                $fields[$contentBundleKey] = $artwork[$artworkKey];
            }
        } else {
            foreach ($credits_map as $contentBundleKey => $artworkKey) {
                $fields[$contentBundleKey] = '';
            }
        }

        return $fields;
    }

    public function prepareFieldsBeforeCreate($fields)
    {
        if ($fields['credits_input'] == 'datahub') {
            $fields = $this->updateFieldsFromApi($fields);
        }

        return parent::prepareFieldsBeforeCreate($fields);
    }

    public function prepareFieldsBeforeSave($object, $fields)
    {
        if ($fields['credits_input'] == 'datahub') {
            $fields = $this->updateFieldsFromApi($fields);
        }

        return parent::prepareFieldsBeforeSave($object, $fields);
    }
}

<?php

namespace App\Repositories;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use App\Models\Api\Artwork;
use App\Models\ExperienceImage;

class ExperienceImageRepository extends ModuleRepository
{
    use HandleBlocks;
    use HandleMedias;
    use HandleFiles;
    use HandleRevisions;

    public function __construct(ExperienceImage $model)
    {
        $this->model = $model;
    }

    public function updateFieldsFromApi($fields): array
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

    public function prepareFieldsBeforeCreate(array $fields): array
    {
        if ($fields['credits_input'] == 'datahub') {
            $fields = $this->updateFieldsFromApi($fields);
        }

        return parent::prepareFieldsBeforeCreate($fields);
    }

    public function prepareFieldsBeforeSave(TwillModelContract $object, array $fields): array
    {
        if ($fields['credits_input'] == 'datahub') {
            $fields = $this->updateFieldsFromApi($fields);
        }

        return parent::prepareFieldsBeforeSave($object, $fields);
    }
}

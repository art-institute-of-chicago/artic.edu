<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Api\Artwork;
use App\Models\ExperienceImage;

class ExperienceImageRepository extends ModuleRepository
{
    use HandleBlocks, HandleMedias, HandleFiles, HandleRevisions;

    public function __construct(ExperienceImage $model)
    {
        $this->model = $model;
    }

    public function prepareFieldsBeforeCreate($fields)
    {
        $fields = parent::prepareFieldsBeforeCreate($fields);
        if (!empty($fields['object_id'])) {
            $object_id = $fields['object_id'];
            $apiResult = Artwork::query()->find($object_id);
            if ($apiResult instanceof Artwork) {
                $artwork = $apiResult->toArray();
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
                foreach($credits_map as $contentBundleKey => $artworkKey) {
                    if (!$fields[$contentBundleKey]) {
                        $fields[$contentBundleKey] = $artwork[$artworkKey];
                    }
                }
            }
        }
        return $fields;
    }
}

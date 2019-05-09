<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\ExperienceModal;
use App\Repositories\Behaviors\HandleExperienceModule;

class ExperienceModalRepository extends ModuleRepository
{
    use HandleBlocks, HandleMedias, HandleFiles, HandleRevisions, HandleExperienceModule;

    public function __construct(ExperienceModal $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        // dd($fields);
        $this->updateExperienceModule($object, $fields, 'experienceImage', 'ExperienceImage', 'modal_experience_image');
        parent::afterSave($object, $fields);
}

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        return $fields;
    }

    public function prepareFieldsBeforeSave($object, $fields)
    {
        if (isset($fields['blocks']) && !is_null($fields['blocks'])) {
            $fields['repeaters'] = $fields['blocks'];
            unset($fields['blocks']);
        };

        if (isset($fields['image_sequence_playback'])) {
            $fields['image_sequence_playback'] = json_encode($fields['image_sequence_playback']);
        }

        return parent::prepareFieldsBeforeCreate($fields);
    }
}

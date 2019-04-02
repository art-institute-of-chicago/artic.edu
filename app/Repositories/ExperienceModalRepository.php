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
        $this->updateExperienceModule($object, $fields, 'experienceImage', 'ExperienceImage', 'experience_image');
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getExperienceModule($object, $fields, 'experienceImage', 'ExperienceImage', 'experience_image');
        $fields['blocks'] = $fields['repeaters'];
        return $fields;
    }

    public function prepareFieldsBeforeSave($object, $fields)
    {
        if (isset($fields['blocks']) && !is_null($fields['blocks'])) {
            $fields['repeaters'] = $fields['blocks'];
            unset($fields['blocks']);
        };
        return parent::prepareFieldsBeforeSave($object, $fields);
    }
}

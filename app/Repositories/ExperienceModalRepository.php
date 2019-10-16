<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\ExperienceModal;
use App\Repositories\Behaviors\HandleExperienceModule;
use App\Repositories\Behaviors\Handle3DModel;

class ExperienceModalRepository extends ModuleRepository
{
    use HandleBlocks, HandleMedias, HandleFiles, HandleRevisions, HandleExperienceModule, Handle3DModel;

    public function __construct(ExperienceModal $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateExperienceModule($object, $fields, 'experienceImage', 'ExperienceImage', 'modal_experience_image');
        if ($object->modal_type === '3d_modal') {
            $this->handle3DModel($object, $fields, 'aic_split_3d_model');
        }
        parent::afterSave($object, $fields);
}

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getFormFieldsFor3DModel($object, $fields, 'aic_split_3d_model');

        return $fields;
    }

    public function prepareFieldsBeforeSave($object, $fields)
    {
        if (isset($fields['blocks']) && !empty($fields['blocks'])) {
            $fields['repeaters'] = $fields['blocks'];
            unset($fields['blocks']);
        };
        
        return parent::prepareFieldsBeforeCreate($fields);
    }
}

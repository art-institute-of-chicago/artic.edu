<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Slide;
use App\Repositories\Behaviors\HandleExperienceImage;

class SlideRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions, HandleExperienceImage;

    public function __construct(Slide $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateExperienceImage($object, $fields, 'primaryExperienceImage', 'ExperienceImage', 'slide_primary_experience_image');
        $this->updateExperienceImage($object, $fields, 'secondaryExperienceImage', 'ExperienceImage', 'slide_secondary_experience_image');
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getExperienceImage($object, $fields, 'primaryExperienceImage', 'ExperienceImage', 'slide_primary_experience_image');
        $fields = $this->getExperienceImage($object, $fields, 'secondaryExperienceImage', 'ExperienceImage', 'slide_secondary_experience_image');
        return $fields;
    }

    public function prepareFieldsBeforeSave($object, $fields)
    {
        $fields['attributes'] = json_encode($fields['attributes']);
        return parent::prepareFieldsBeforeSave($object, $fields);
    }
}

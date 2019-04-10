<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Slide;
use App\Repositories\Behaviors\HandleExperienceModule;

class SlideRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions, HandleExperienceModule;

    public function __construct(Slide $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateExperienceModule($object, $fields, 'primaryExperienceImage', 'ExperienceImage', 'slide_primary_experience_image');
        $this->updateExperienceModule($object, $fields, 'secondaryExperienceImage', 'ExperienceImage', 'slide_secondary_experience_image');
        $this->updateExperienceModule($object, $fields, 'experienceImage', 'ExperienceImage', 'experience_image');
        $this->updateExperienceModule($object, $fields, 'compareExperienceImage1', 'ExperienceImage', 'compare_experience_image_1');
        $this->updateExperienceModule($object, $fields, 'compareExperienceImage2', 'ExperienceImage', 'compare_experience_image_2');
        $this->updateExperienceModule($object, $fields, 'experienceModal', 'ExperienceModal', 'experience_modal');
        $this->updateExperienceModule($object, $fields, 'primaryExperienceModal', 'ExperienceModal', 'primary_experience_modal');
        $this->updateExperienceModule($object, $fields, 'secondaryExperienceModal', 'ExperienceModal', 'secondary_experience_modal');
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getExperienceModule($object, $fields, 'primaryExperienceImage', 'ExperienceImage', 'slide_primary_experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'secondaryExperienceImage', 'ExperienceImage', 'slide_secondary_experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'experienceImage', 'ExperienceImage', 'experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'compareExperienceImage2', 'ExperienceImage', 'compare_experience_image_1');
        $fields = $this->getExperienceModule($object, $fields, 'compareExperienceImage2', 'ExperienceImage', 'compare_experience_image_2');
        $fields = $this->getExperienceModule($object, $fields, 'experienceModal', 'ExperienceModal', 'experience_modal');
        $fields = $this->getExperienceModule($object, $fields, 'primaryExperienceModal', 'ExperienceModal', 'primary_experience_modal');
        $fields = $this->getExperienceModule($object, $fields, 'secondaryExperienceModal', 'ExperienceModal', 'secondary_experience_modal');
        return $fields;
    }

    public function prepareFieldsBeforeSave($object, $fields)
    {
        if (isset($fields['attributes'])) {
            $fields['attributes'] = json_encode($fields['attributes']);
        }
        return parent::prepareFieldsBeforeSave($object, $fields);
    }
}

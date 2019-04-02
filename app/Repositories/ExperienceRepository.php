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
use App\Repositories\Behaviors\HandleExperienceModule;

class ExperienceRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions, HandleRepeaters, HandleExperienceModule;

    public function __construct(Experience $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $this->updateExperienceModule($object, $fields, 'attractExperienceImages', 'ExperienceImage', 'attract_experience_image');
        $this->updateExperienceModule($object, $fields, 'endBackgroundExperienceImages', 'ExperienceImage', 'end_bg_experience_image');
        $this->updateExperienceModule($object, $fields, 'endExperienceImages', 'ExperienceImage', 'end_experience_image');
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getExperienceModule($object, $fields, 'attractExperienceImages', 'ExperienceImage', 'attract_experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'endBackgroundExperienceImages', 'ExperienceImage', 'end_bg_experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'endExperienceImages', 'ExperienceImage', 'end_experience_image');
        return $fields;
    }

    public function getCountByStatusSlug($slug, $scope = [])
    {
        $scope = $scope + ['archived' => false];
        return parent::getCountByStatusSlug($slug, $scope);
    }
}

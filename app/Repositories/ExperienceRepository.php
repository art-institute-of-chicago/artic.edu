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
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        return $fields;
    }

    public function getCountByStatusSlug($slug, $scope = [])
    {
        $scope = $scope + ['archived' => false];
        return parent::getCountByStatusSlug($slug, $scope);
    }

    public function create($fields)
    {
        $experience = parent::create($fields);
        $attract_fields = [
            'title' => 'Attract',
            'module_type' => 'attract',
            'experience_id' => $experience->id,
        ];
        $end_fields = [
            'title' => 'End',
            'module_type' => 'end',
            'experience_id' => $experience->id,
        ];
        app(\App\Repositories\SlideRepository::class)->create($attract_fields);
        app(\App\Repositories\SlideRepository::class)->create($end_fields);
        return $experience;
    }
}

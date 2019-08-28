<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use A17\Twill\Repositories\ModuleRepository;
use App\Models\Slide;
use App\Models\AIC3DModel;
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
        $this->updateExperienceModule($object, $fields, 'seamlessExperienceImage', 'ExperienceImage', 'seamless_experience_image');
        $this->updateExperienceModule($object, $fields, 'tooltipExperienceImage', 'ExperienceImage', 'tooltip_experience_image');
        $this->updateExperienceModule($object, $fields, 'interstitialExperienceImage', 'ExperienceImage', 'interstitial_experience_image');
        $this->updateExperienceModule($object, $fields, 'fullwidthmediaExperienceImage', 'ExperienceImage', 'fullwidthmedia_experience_image');
        $this->updateExperienceModule($object, $fields, 'compareExperienceImage1', 'ExperienceImage', 'compare_experience_image_1');
        $this->updateExperienceModule($object, $fields, 'compareExperienceImage2', 'ExperienceImage', 'compare_experience_image_2');
        $this->updateExperienceModule($object, $fields, 'compareExperienceModal', 'ExperienceImage', 'compare_experience_modal');
        $this->updateExperienceModule($object, $fields, 'experienceModal', 'ExperienceModal', 'experience_modal');
        $this->updateExperienceModule($object, $fields, 'primaryExperienceModal', 'ExperienceModal', 'primary_experience_modal');
        $this->updateExperienceModule($object, $fields, 'secondaryExperienceModal', 'ExperienceModal', 'secondary_experience_modal');
        $this->updateExperienceModule($object, $fields, 'attractExperienceImages', 'ExperienceImage', 'attract_experience_image');
        $this->updateExperienceModule($object, $fields, 'endBackgroundExperienceImages', 'ExperienceImage', 'end_bg_experience_image');
        $this->updateExperienceModule($object, $fields, 'endExperienceImages', 'ExperienceImage', 'end_experience_image');
        if ($object->module_type === '3dtour') {
            $this->handle3DModel($object, $fields);
        }
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getExperienceModule($object, $fields, 'primaryExperienceImage', 'ExperienceImage', 'slide_primary_experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'secondaryExperienceImage', 'ExperienceImage', 'slide_secondary_experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'experienceImage', 'ExperienceImage', 'experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'seamlessExperienceImage', 'ExperienceImage', 'seamless_experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'tooltipExperienceImage', 'ExperienceImage', 'tooltip_experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'interstitialExperienceImage', 'ExperienceImage', 'interstitial_experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'fullwidthmediaExperienceImage', 'ExperienceImage', 'fullwidthmedia_experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'compareExperienceImage1', 'ExperienceImage', 'compare_experience_image_1');
        $fields = $this->getExperienceModule($object, $fields, 'compareExperienceImage2', 'ExperienceImage', 'compare_experience_image_2');
        $fields = $this->getExperienceModule($object, $fields, 'compareExperienceModal', 'ExperienceImage', 'compare_experience_modal');
        $fields = $this->getExperienceModule($object, $fields, 'experienceModal', 'ExperienceModal', 'experience_modal');
        $fields = $this->getExperienceModule($object, $fields, 'primaryExperienceModal', 'ExperienceModal', 'primary_experience_modal');
        $fields = $this->getExperienceModule($object, $fields, 'secondaryExperienceModal', 'ExperienceModal', 'secondary_experience_modal');
        $fields = $this->getExperienceModule($object, $fields, 'attractExperienceImages', 'ExperienceImage', 'attract_experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'endBackgroundExperienceImages', 'ExperienceImage', 'end_bg_experience_image');
        $fields = $this->getExperienceModule($object, $fields, 'endExperienceImages', 'ExperienceImage', 'end_experience_image');
        $fields = $this->getFormFieldsFor3DModel($object, $fields);
        return $fields;
    }

    public function create($fields)
    {
        $slide = parent::create($fields);
        if (isset($fields['module_type']) && in_array($fields['module_type'], ['attract', 'end'])) {
            return $slide;
        }
        // the position of newly create slide should always between attract and end
        $end_slide = $this->where([['module_type', 'end'], ['experience_id', $slide->experience_id]])->firstOrFail();
        $slide->position = $end_slide->position;
        $slide->save();
        $end_slide->position = $this->getCountForAll() + 1;
        $end_slide->save();
        return $slide;
    }

    private function handle3DModel($object, $fields)
    {
        if (!empty($fields['model_id']) 
            && !empty($fields['camera_position'])
            && !empty($fields['camera_target'])
            && !empty($fields['annotation_list'])
        ) {
            $model = AIC3DModel::updateOrCreate(
                [
                    'model_id' => $fields['model_id']
                ],
                [
                    'model_id' => $fields['model_id'],
                    'camera_position' => $fields['camera_position'],
                    'camera_target' => $fields['camera_target'],
                    'annotation_list' => $fields['annotation_list'],
                ]
            );
            $object->AIC3DModel()->associate($model);
            $object->save();
        }
    }

    private function getFormFieldsFor3DModel($object, $fields)
    {
        $aic3dModel = $object->AIC3DModel;
        if ($aic3dModel) {
            $fields['model_id'] = $aic3dModel->model_id;
            $fields['camera_position'] = $aic3dModel->getOriginal('camera_position');
            $fields['camera_target'] = $aic3dModel->getOriginal('camera_target');
            $fields['annotation_list'] = $aic3dModel->getOriginal('annotation_list');
        };
        return $fields;
    }
}

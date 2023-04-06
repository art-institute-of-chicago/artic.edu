<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\Slide;
use App\Repositories\Behaviors\HandleExperienceModule;
use App\Repositories\Behaviors\Handle3DModel;

class SlideRepository extends ModuleRepository
{
    use HandleBlocks;
    use HandleSlugs;
    use HandleMedias;
    use HandleFiles;
    use HandleRevisions;
    use HandleExperienceModule;
    use Handle3DModel;

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

        if (in_array($object->module_type, ['3dtour', 'split', 'fullwidthmedia'])) {
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
        $fields = $this->getFormFieldsFor3DModel($object, $fields, 'aic_3d_model');
        $fields = $this->getFormFieldsFor3DModel($object, $fields, 'aic_split_3d_model');

        return $fields;
    }

    public function create($fields)
    {
        $slide = parent::create($fields);

        if (isset($fields['module_type']) && in_array($fields['module_type'], ['attract', 'end'])) {
            return $slide;
        }
        // The position of newly create slide should always between attract and end
        $end_slide = $this->where([['module_type', 'end'], ['experience_id', $slide->experience_id]])->firstOrFail();
        $slide->position = $end_slide->position;
        $slide->save();
        $end_slide->position = $this->getCountForAll() + 1;
        $end_slide->save();

        return $slide;
    }
}

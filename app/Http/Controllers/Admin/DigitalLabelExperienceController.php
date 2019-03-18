<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class DigitalLabelExperienceController extends ModuleController
{
    protected $moduleName = 'digitalLabels.experiences';
    protected $modelName = 'Experience';

    protected function getParentModuleForeignKey()
    {
        return 'digital_label_id';
    }
}

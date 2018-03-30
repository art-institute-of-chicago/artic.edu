<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class ResearchGuideController extends ModuleController
{
    protected $moduleName = 'researchGuides';

    protected function formData($request)
    {
        $baseUrl = '//'.config('app.url')."/collection/resources/research-guides/";
        return [
            'baseUrl' => $baseUrl
        ];
    }

}

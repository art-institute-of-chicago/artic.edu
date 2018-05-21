<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\ResearchGuideRepository;

class ResearchGuideController extends ModuleController
{
    protected $moduleName = 'researchGuides';
    protected $previewView = 'site.genericPage.show';

    protected function formData($request)
    {
        $baseUrl = '//' . config('app.url') . "/collection/resources/research-guides/";
        return [
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }

}

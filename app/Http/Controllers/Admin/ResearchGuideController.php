<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

use App\Repositories\ResearchGuideRepository;

class ResearchGuideController extends ModuleController
{
    protected $moduleName = 'researchGuides';
    protected $previewView = 'site.genericPage.show';

    protected function formData($request)
    {
        $baseUrl = '//'.config('app.url')."/collection/resources/research-guides/";
        return [
            'baseUrl' => $baseUrl
        ];
    }

    protected function previewData($item)
    {
        // The ID is a datahub_id not a local ID
        $apiRepo = app(ResearchGuideRepository::class);
        $apiItem = $apiRepo->getById($item->id);

        return $apiRepo->getShowData($item);
    }

}

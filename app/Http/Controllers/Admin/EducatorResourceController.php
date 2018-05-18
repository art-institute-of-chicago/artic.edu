<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

use App\Repositories\EducatorResourceRepository;
use App\Repositories\ResourceCategoryRepository;

class EducatorResourceController extends ModuleController
{
    protected $moduleName = 'educatorResources';
    protected $previewView = 'site.genericPage.show';

    protected function formData($request)
    {
        $baseUrl = '//'.config('app.url')."/collection/resources/educator-resources/";
        return [
            'categoriesList' => app(ResourceCategoryRepository::class)->listAll('name'),
            'baseUrl' => $baseUrl
        ];
    }

    protected function previewData($item)
    {
        // The ID is a datahub_id not a local ID
        $apiRepo = app(EducatorResourceRepository::class);
        $apiItem = $apiRepo->getById($item->id);

        return $apiRepo->getShowData($item);
    }
}

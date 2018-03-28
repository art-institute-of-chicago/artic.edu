<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\ResourceCategoryRepository;

class EducatorResourceController extends ModuleController
{
    protected $moduleName = 'educatorResources';

    protected function formData($request)
    {
        return [
            'categoriesList' => app(ResourceCategoryRepository::class)->listAll('name'),
        ];
    }
}

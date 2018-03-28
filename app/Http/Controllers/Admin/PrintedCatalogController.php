<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\CatalogCategoryRepository;

class PrintedCatalogController extends ModuleController
{
    protected $moduleName = 'printedCatalogs';

    protected function formData($request)
    {
        return [
            'categoriesList' => app(CatalogCategoryRepository::class)->listAll('name'),
        ];
    }
}

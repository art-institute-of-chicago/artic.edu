<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\CatalogCategoryRepository;

class PrintedCatalogController extends ModuleController
{
    protected $moduleName = 'printedCatalogs';
    protected $previewView = 'site.printedcatalogs.show';

    protected function formData($request)
    {
        $baseUrl = '//'.config('app.url')."/collection/publications/printed-catalogs/";
        return [
            'categoriesList' => app(CatalogCategoryRepository::class)->listAll('name'),
            'baseUrl' => $baseUrl
        ];
    }

}

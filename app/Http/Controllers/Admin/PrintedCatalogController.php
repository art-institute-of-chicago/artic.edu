<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\CatalogCategoryRepository;

use App\Repositories\PrintedCatalogRepository;

class PrintedCatalogController extends ModuleController
{
    protected $moduleName = 'printedCatalogs';
    protected $previewView = 'site.genericPage.show';

    protected function formData($request)
    {
        $baseUrl = '//'.config('app.url')."/collection/publications/printed-catalogs/";
        return [
            'categoriesList' => app(CatalogCategoryRepository::class)->listAll('name'),
            'baseUrl' => $baseUrl
        ];
    }

    protected function previewData($item)
    {
        // The ID is a datahub_id not a local ID
        $apiRepo = app(PrintedCatalogRepository::class);
        $apiItem = $apiRepo->getById($item->id);

        return $apiRepo->getShowData($item);
    }

}

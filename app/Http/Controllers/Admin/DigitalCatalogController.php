<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

use App\Repositories\DigitalCatalogRepository;

class DigitalCatalogController extends ModuleController
{
    protected $moduleName = 'digitalCatalogs';
    protected $previewView = 'site.genericPage.show';

    protected function formData($request)
    {
        $baseUrl = '//'.config('app.url')."/collection/publications/digital-catalogs/";
        return [
            'baseUrl' => $baseUrl
        ];
    }

    protected function previewData($item)
    {
        // The ID is a datahub_id not a local ID
        $apiRepo = app(DigitalCatalogRepository::class);
        $apiItem = $apiRepo->getById($item->id);

        return $apiRepo->getShowData($item);
    }

}

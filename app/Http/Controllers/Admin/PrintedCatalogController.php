<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\CatalogCategoryRepository;
use App\Repositories\PrintedCatalogRepository;

class PrintedCatalogController extends ModuleController
{
    protected $moduleName = 'printedCatalogs';
    protected $previewView = 'site.genericPage.show';

    protected function formData($request)
    {
        $baseUrl = '//' . config('app.url') . "/printed-catalogues/";
        return [
            'categoriesList' => app(CatalogCategoryRepository::class)->listAll('name'),
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }

}

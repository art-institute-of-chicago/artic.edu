<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\CatalogCategoryRepository;

class PrintedPublicationController extends ModuleController
{
    protected $moduleName = 'printedPublications';
    protected $previewView = 'site.genericPage.show';

    protected function formData($request)
    {
        $baseUrl = '//' . config('app.url') . '/print-publications/';

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

<?php

namespace App\Http\Controllers\Twill;

use App\Repositories\CatalogCategoryRepository;

class PrintedPublicationController extends \App\Http\Controllers\Twill\ModuleController
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

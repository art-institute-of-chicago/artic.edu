<?php

namespace App\Http\Controllers\Twill;

use App\Repositories\CatalogCategoryRepository;

class PrintedPublicationController extends BaseController
{
    protected function setUpController(): void
    {
        $this->setModuleName('printedPublications');
        $this->setPreviewView('site.genericPage.show');
    }

    protected function formData($request)
    {
        $baseUrl = config('app.url') . '/print-publications/';

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

<?php

namespace App\Http\Controllers\Twill;

use App\Repositories\ResourceCategoryRepository;

class EducatorResourceController extends BaseController
{
    protected function setUpController(): void
    {
        parent::setUpController();
        $this->setModuleName('educatorResources');
        $this->setPreviewView('site.genericPage.show');
    }

    protected function formData($request)
    {
        $baseUrl = config('app.url') . '/collection/resources/educator-resources/';

        return [
            'categoriesList' => app(ResourceCategoryRepository::class)->listAll('name'),
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}

<?php

namespace App\Http\Controllers\Twill;

use App\Repositories\ResourceCategoryRepository;

class EducatorResourceController extends BaseController
{
    protected function setUpController(): void
    {
        $this->setModuleName('educatorResources');
        $this->setPreviewView('site.genericPage.show');
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('educatorResource') ?? request('id'));
        $baseUrl = config('app.url') . '/educator-resources/' . $item->id . '/';

        return [
            'categoriesList' => app(ResourceCategoryRepository::class)->listAll('name'),
            'baseUrl' => $baseUrl
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}

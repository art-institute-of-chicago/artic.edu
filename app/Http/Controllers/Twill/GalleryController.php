<?php

namespace App\Http\Controllers\Twill;

class GalleryController extends BaseApiController
{
    protected function setUpController(): void
    {
        parent::setUpController();
        $this->setModuleName('galleries');
        $this->enableAugmentedModel();
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('gallery') ?? request('id'));
        $baseUrl = config('app.url') . '/galleries/' . $item->datahub_id . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }
}

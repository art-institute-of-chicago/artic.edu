<?php

namespace App\Http\Controllers\Twill;

class GalleryController extends BaseApiController
{
    protected function setUpController(): void
    {
        $this->setModuleName('galleries');
        $this->enableAugmentedModel();
        $this->disablePublish();
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

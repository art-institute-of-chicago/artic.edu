<?php

namespace App\Http\Controllers\Twill;

class MiradorController extends BaseController
{
    protected function setUpController(): void
    {
        $this->setModuleName('miradors');
        $this->setPreviewView('site.miradorDetail');
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('mirador') ?? request('id'));
        $baseUrl = config('app.url') . '/mirador/' . $item->id . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }
}

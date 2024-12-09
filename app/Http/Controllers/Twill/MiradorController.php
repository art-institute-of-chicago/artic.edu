<?php

namespace App\Http\Controllers\Twill;

class MiradorController extends \App\Http\Controllers\Twill\ModuleController
{
    protected $moduleName = 'miradors';
    protected $previewView = 'site.miradorDetail';

    protected function formData($request)
    {
        $item = $this->repository->getById(request('mirador') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/mirador/' . $item->id . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }
}

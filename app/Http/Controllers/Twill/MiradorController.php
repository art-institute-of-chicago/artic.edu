<?php

namespace App\Http\Controllers\Admin;

class MiradorController extends ModuleController
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

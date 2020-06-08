<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class AuthorController extends ModuleController
{
    protected $moduleName = 'authors';

    protected function formData($request)
    {
        $item = $this->repository->getById(request('author') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/authors/' . $item->id . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }
}

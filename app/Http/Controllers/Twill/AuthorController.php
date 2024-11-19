<?php

namespace App\Http\Controllers\Admin;

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

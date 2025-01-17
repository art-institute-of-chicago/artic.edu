<?php

namespace App\Http\Controllers\Twill;

class AuthorController extends \App\Http\Controllers\Twill\ModuleController
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

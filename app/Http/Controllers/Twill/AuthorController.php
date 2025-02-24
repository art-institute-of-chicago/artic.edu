<?php

namespace App\Http\Controllers\Twill;

class AuthorController extends BaseController
{
    protected function setUpController(): void
    {
        parent::setUpController();
        $this->setModuleName('authors');
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('author') ?? request('id'));
        $baseUrl = config('app.url') . '/authors/' . $item->id . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }
}

<?php

namespace App\Http\Controllers\Twill;

class MagazineIssueController extends BaseController
{
    protected $permalinkBase = 'magazine/issues/';

    protected function setUpController(): void
    {
        $this->enableShowImage();
        $this->setModuleName('magazineIssues');
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('magazineIssue') ?? request('id'));
        $baseUrl = config('app.url') . '/' . $this->permalinkBase . $item->id . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }
}

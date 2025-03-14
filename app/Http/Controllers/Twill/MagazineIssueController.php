<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;

class MagazineIssueController extends BaseController
{
    protected $permalinkBase = 'magazine/issues/';

    protected function setUpController(): void
    {
        parent::setUpController();
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

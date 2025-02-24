<?php

namespace App\Http\Controllers\Twill;

class DepartmentController extends BaseApiController
{
    protected function setUpController(): void
    {
        $this->setModuleName('departments');
        $this->enableAugmentedModel();
        $this->disablePublish();
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('department') ?? request('id'));
        $baseUrl = config('app.url') . '/departments/' . $item->datahub_id . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }
}

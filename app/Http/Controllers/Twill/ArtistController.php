<?php

namespace App\Http\Controllers\Twill;

class ArtistController extends BaseApiController
{
    public function setUpController(): void
    {
        $this->disableBulkDelete();
        $this->disableBulkEdit();
        $this->disableBulkPublish();
        $this->disableCreate();
        $this->disableDelete();
        $this->disablePermalink();
        $this->disablePublish();
        $this->disableRestore();
        $this->enableAugmentedModel();
        $this->setModuleName('artists');
        $this->setTitleColumnLabel('Name');
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('artist') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/artists/' . $item->datahub_id . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }
}

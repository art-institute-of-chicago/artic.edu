<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\DigitalPublicationRepository;

class DigitalPublicationController extends ModuleController
{
    protected $moduleName = 'digitalPublications';
    protected $previewView = 'site.genericPage.show';

    protected function formData($request)
    {
        $baseUrl = '//' . config('app.url') . "/digital-publications/";
        return [
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }

}

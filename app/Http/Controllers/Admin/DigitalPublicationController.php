<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\DigitalPublicationRepository;

class DigitalPublicationController extends ModuleController
{
    protected $moduleName = 'digitalPublications';
    protected $previewView = 'site.genericPage.show';

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ],
        'type' => [
            'title' => 'Is DSC stub?',
            'field' => 'isDscStub',
            'sort' => true,
            'present' => true,
        ],
    ];

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

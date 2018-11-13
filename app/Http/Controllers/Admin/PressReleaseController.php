<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\PressReleaseRepository;

class PressReleaseController extends ModuleController
{
    protected $moduleName = 'pressReleases';
    protected $previewView = 'site.genericPage.show';

    protected $defaultOrders = ['publish_start_date' => 'desc'];

    protected $indexColumns = [
        'title' => [
            'field' => 'title',
            'title' => 'Title',
        ],
        'publish_start_date' => [
            'title' => 'Publish Date',
            'present' => true,
            'field' => 'presentPublishStartDate',
            'sort' => true,
        ],
    ];

    protected function formData($request)
    {
        $baseUrl = '//' . config('app.url') . '/press/press-releases/' . request('pressRelease') . '-';
        return [
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}

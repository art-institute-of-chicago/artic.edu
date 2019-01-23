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
        # The key must equal the field, else sortKey cannot be reached
        'presentPublishStartDate' => [
            'title' => 'Publish Date',
            'present' => true,
            'field' => 'presentPublishStartDate',
            'sort' => true,
            'sortKey' => 'publish_start_date',
        ],
    ];

    protected function formData($request)
    {
        $baseUrl = '//' . config('app.url') . '/press/press-releases/' . request('pressRelease') . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }

    protected function previewData($item)
    {
        return $this->repository->getShowData($item);
    }
}

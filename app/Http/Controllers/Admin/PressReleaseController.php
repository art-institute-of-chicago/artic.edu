<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

use App\Repositories\PressReleaseRepository;

class PressReleaseController extends ModuleController
{
    protected $moduleName = 'pressReleases';
    protected $previewView = 'site.pressreleases.show';

    protected $defaultOrders = ['publish_start_date' => 'desc'];

    protected $indexColumns = [
        'title' => [
            'field' => 'title',
            'title' => 'Title'
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
        $baseUrl = '//'.config('app.url')."/about/press/";
        return [
            'baseUrl' => $baseUrl
        ];
    }

    protected function previewData($item)
    {
        // The ID is a datahub_id not a local ID
        $apiRepo = app(PressReleaseRepository::class);
        $apiItem = $apiRepo->getById($item->id);

        return $apiRepo->getShowData($item);
    }
}

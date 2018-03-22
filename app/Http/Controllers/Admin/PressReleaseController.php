<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class PressReleaseController extends ModuleController
{
    protected $moduleName = 'pressReleases';

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

}

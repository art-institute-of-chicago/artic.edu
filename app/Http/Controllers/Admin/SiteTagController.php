<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class SiteTagController extends ModuleController
{
    protected $moduleName = 'siteTags';

    protected $indexOptions = [
        'publish' => false,
        'editInModal' => true,
    ];

    protected $titleColumnKey = 'name';

    protected $indexColumns = [
        'name' => [
            'title' => 'Name',
            'edit_link' => true,
            'field' => 'name',
        ],
    ];

    protected $defaultOrders = [
        'name' => 'asc',
    ];
}

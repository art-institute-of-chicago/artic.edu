<?php

namespace App\Http\Controllers\Admin;

class SiteTagController extends ModuleController
{
    protected $moduleName = 'siteTags';

    protected $indexOptions = [
        'publish' => false,
        'editInModal' => true,
        'permalink' => false,
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

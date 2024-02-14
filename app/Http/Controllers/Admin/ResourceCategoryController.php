<?php

namespace App\Http\Controllers\Admin;

class ResourceCategoryController extends ModuleController
{
    protected $moduleName = 'resourceCategories';

    protected $indexOptions = [
        'publish' => false,
        'editInModal' => true,
        'permalink' => false,
        'reorder' => true
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

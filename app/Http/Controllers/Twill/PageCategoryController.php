<?php

namespace App\Http\Controllers\Twill;

class PageCategoryController extends \App\Http\Controllers\Twill\ModuleController
{
    protected $moduleName = 'pageCategories';

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

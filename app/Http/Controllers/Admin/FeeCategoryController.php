<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class FeeCategoryController extends ModuleController
{
    protected $moduleName = 'feeCategories';

    protected $defaultOrders = ['position' => 'asc'];

    protected $indexOptions = [
        'publish' => false,
        'permalink' => false,
        'editInModal' => true,
        'reorder' => true,
    ];

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
        ],
        'tooltip' => [
            'title' => 'Tooltip',
            'field' => 'tooltip',
        ],
    ];
}

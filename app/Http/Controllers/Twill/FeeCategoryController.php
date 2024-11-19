<?php

namespace App\Http\Controllers\Admin;

class FeeCategoryController extends ModuleController
{
    protected $moduleName = 'feeCategories';

    protected $defaultOrders = ['position' => 'asc'];

    protected $indexOptions = [
        'publish' => false,
        'permalink' => false,
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

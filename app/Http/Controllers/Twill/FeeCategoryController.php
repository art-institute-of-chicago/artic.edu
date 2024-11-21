<?php

namespace App\Http\Controllers\Twill;

class FeeCategoryController extends \App\Http\Controllers\Twill\ModuleController
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

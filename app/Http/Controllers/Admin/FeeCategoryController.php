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

    // {{-- Remove buttons when there're 5 or more Categories  --}}
    // @if (count($items) >= 5)
    //     @section('footer')
    //     @stop
    // @endif
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

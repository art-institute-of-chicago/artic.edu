<?php

namespace App\Http\Controllers\Admin;

class FeeAgeController extends ModuleController
{
    protected $moduleName = 'feeAges';

    protected $defaultOrders = ['position' => 'asc'];

    protected $indexOptions = [
        'publish' => false,
        'permalink' => false,
        'editInModal' => true,
        'reorder' => true,
    ];
}

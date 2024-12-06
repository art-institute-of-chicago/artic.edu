<?php

namespace App\Http\Controllers\Twill;

class FeeAgeController extends \App\Http\Controllers\Twill\ModuleController
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

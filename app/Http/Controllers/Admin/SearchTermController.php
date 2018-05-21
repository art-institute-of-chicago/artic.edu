<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class SearchTermController extends ModuleController
{
    protected $moduleName = 'searchTerms';

    protected $indexOptions = [
        'publish' => false,
        'reorder' => true,
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

    protected $defaultOrders = ['position' => 'asc'];

}

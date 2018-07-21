<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;

class EventProgramController extends ModuleController
{
    protected $moduleName = 'eventPrograms';

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

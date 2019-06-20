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
        'is_affiliate_group' => [
            'title' => 'Affiliate Group?',
            'edit_link' => false,
            'field' => 'isAffiliateGroup',
            'optional' => false,
            'present' => true,
        ],
    ];

    protected $defaultOrders = [
        'name' => 'asc',
    ];
}

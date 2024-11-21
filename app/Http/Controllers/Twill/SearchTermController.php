<?php

namespace App\Http\Controllers\Twill;

class SearchTermController extends \App\Http\Controllers\Twill\ModuleController
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
        'direct_url' => [
            'title' => 'Direct URL',
            'field' => 'direct_url',
        ],
    ];

    protected $defaultOrders = ['position' => 'asc'];
}

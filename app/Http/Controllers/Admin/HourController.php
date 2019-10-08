<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Models\Hour;

class HourController extends ModuleController
{
    protected $moduleName = 'hours';

    protected $indexOptions = [
        'publish' => false,
        'delete' => false,
        'create' => false,
    ];

    protected $titleColumnKey = 'title';

    protected $indexColumns = [
        'type' => [
            'title' => 'Type',
            'present' => true,
            'field' => 'presentType',
            'edit_link' => true,
        ],
        'title' => [
            'title' => 'Title',
            'present' => true,
            'field' => 'title',
            'edit_link' => true,
        ],
        'url' => [
            'title' => 'Link URL',
            'present' => true,
            'field' => 'url',
        ],
        'valieFrom' => [
            'title' => 'Valid From',
            'present' => true,
            'field' => 'validFrom',
        ],
        'validThrough' => [
            'title' => 'Valid Through',
            'present' => true,
            'field' => 'validThrough',
        ],
    ];

    /*
     * Relations to eager load for the index view
     */
    protected $indexWith = [];

    /*
     * Relations to eager load for the form view
     */
    protected $formWith = [];

    protected $defaultOrders = ['type' => 'asc'];

    protected function indexData($request)
    {
        return [
            'fTypeList' => [null => 'All types'] + Hour::$types,
        ];
    }

    protected function formData($request)
    {
        return [];
    }

}

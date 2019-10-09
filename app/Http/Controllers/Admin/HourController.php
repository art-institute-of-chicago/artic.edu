<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Models\Hour;

class HourController extends ModuleController
{
    protected $moduleName = 'hours';

    protected $titleColumnKey = 'title';

    protected $indexColumns = [
        'type' => [
            'title' => 'Type',
            'present' => true,
            'field' => 'type',
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
        'validFrom' => [
            'title' => 'Valid From',
            'present' => true,
            'field' => 'validFrom',
            'sort_key' => 'valid_from',
        ],
        'validThrough' => [
            'title' => 'Valid Through',
            'present' => true,
            'field' => 'validThrough',
            'sort_key' => 'valid_through',
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

    protected $defaultOrders = ['valid_from' => 'desc'];

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

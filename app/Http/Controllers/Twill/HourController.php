<?php

namespace App\Http\Controllers\Twill;

use App\Models\Hour;

class HourController extends \App\Http\Controllers\Twill\ModuleController
{
    protected $moduleName = 'hours';

    protected $titleColumnKey = 'title';

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'present' => true,
            'field' => 'title',
            'edit_link' => true,
        ],
        'type' => [
            'title' => 'Type',
            'present' => true,
            'field' => 'type',
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

    /**
     * Relations to eager load for the index view
     */
    protected $indexWith = [];

    /**
     * Relations to eager load for the form view
     */
    protected $formWith = [];

    protected $defaultOrders = ['valid_from' => 'desc'];

    protected function indexData($request)
    {
        return [
            'types' => collect(Hour::$types)->sort(),
        ];
    }

    protected function formData($request)
    {
        return [
            'types' => collect(Hour::$types)->sort(),
        ];
    }
}

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

    protected $titleColumnKey = 'presentType';

    protected $indexColumns = [
        'type' => [
            'title' => 'Type',
            'present' => true,
            'field' => 'presentType',
            'edit_link' => true,
        ],
        'day_of_week' => [
            'title' => 'Day of Week',
            'present' => true,
            'field' => 'dayOfWeek',
            'edit_link' => true,
        ],
        'closed' => [
            'title' => 'Open/Closed',
            'present' => true,
            'field' => 'presentClosed',
        ],
        'opening_time' => [
            'title' => 'Opening Time',
            'present' => true,
            'field' => 'presentOpeningTime',
        ],
        'closing_time' => [
            'title' => 'Closing Time',
            'present' => true,
            'field' => 'presentClosingTime',
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

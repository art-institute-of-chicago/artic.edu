<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Models\Closure;

class ClosureController extends ModuleController
{
    protected $moduleName = 'closures';

    protected $indexOptions = [
        'delete' => false,
    ];

    protected $titleColumnKey = 'presentType';

    protected $indexColumns = [
        'type' => [
            'title' => 'Type',
            'present' => true,
            'field' => 'presentType',
            'edit_link' => true,
        ],
        'opening_time' => [
            'title' => 'Start Date',
            'present' => true,
            'field' => 'presentStartDate',
        ],
        'closing_time' => [
            'title' => 'End Date',
            'present' => true,
            'field' => 'presentEndDate',
        ],
        'title' => [
            'title' => 'Closure Copy',
            'edit_link' => true,
            'sort' => false,
            'field' => 'closure_copy',
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

    /*
     * Filters mapping ('fFilterName' => 'filterColumn')
     * In the indexData function, name your lists with the filter name + List (fFilterNameList)
     */
    protected $filters = [
        'fPresentType' => 'presentType',
    ];

    protected $defaultOrders = ['date_start' => 'desc'];

    protected function indexData($request)
    {
        return [
            'fTypeList' => [null => 'All types'] + Closure::$types,
        ];
    }

    protected function formData($request)
    {
        return [
            'typeList' => collect(Closure::$types),
        ];
    }

}

<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Models\Closure;

class ClosureController extends ModuleController
{
    protected $moduleName = 'closures';

    protected $titleColumnKey = 'presentType';
    protected $titleFormKey = 'cmsFormTitle';

    protected $indexColumns = [
        'presentType' => [
            'title' => 'Type',
            'present' => true,
            'field' => 'presentType',
            'edit_link' => true,
            'sortKey' => 'type',
        ],
        'presentStartDate' => [
            'title' => 'Start Date',
            'present' => true,
            'field' => 'presentStartDate',
            'sort' => true,
            'sortKey' => 'date_start',
        ],
        'presentEndDate' => [
            'title' => 'End Date',
            'present' => true,
            'field' => 'presentEndDate',
            'sort' => true,
            'sortKey' => 'date_end',
        ],
        'closure_copy' => [
            'title' => 'Closure Copy',
            'edit_link' => true,
            'sort' => false,
            'field' => 'closure_copy',
        ],
    ];

    protected $defaultFilters = [
        'search' => '%closure_copy',
    ];

    protected $filters = [
        'types' => 'type',
    ];

    protected $defaultOrders = ['date_start' => 'desc'];

    protected function indexData($request)
    {
        return [
            'typesList' => collect(Closure::$types),
        ];
    }

    protected function formData($request)
    {
        return [
            'typesList' => collect(Closure::$types),
            'editableTitle' => false,
        ];
    }

}

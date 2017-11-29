<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Models\Hour;

class HourController extends ModuleController
{
    protected $moduleName = 'hours';

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
        'fType' => 'type'
    ];

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

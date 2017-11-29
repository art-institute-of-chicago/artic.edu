<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Models\Closure;

class ClosureController extends ModuleController
{
    protected $moduleName = 'closures';

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

    protected function indexData($request)
    {
        return [
            'fTypeList' => [null => 'All types'] + Closure::$types,
        ];
    }

    protected function formData($request)
    {
        return [
            'typeList' => Closure::$types
        ];
    }

}

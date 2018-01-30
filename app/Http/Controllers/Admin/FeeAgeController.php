<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class FeeAgeController extends ModuleController
{
    protected $moduleName = 'feeAges';

    protected $indexOptions = [
        'publish' => false,
    ];

    protected $indexColumns = [
        'title' => [
            'title' => 'Field title',
            'edit_link' => true,
            'sort' => false,
            'field' => 'title',
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
    protected $filters = [];

    protected $defaultOrders = ['position' => 'asc'];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [];
    }

}

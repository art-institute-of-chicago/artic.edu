<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class SponsorController extends ModuleController
{
    protected $moduleName = 'sponsors';

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

    protected $defaultOrders = ['title' => 'asc'];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [];
    }

}

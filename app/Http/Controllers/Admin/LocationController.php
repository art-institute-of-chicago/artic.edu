<?php

namespace App\Http\Controllers\Admin;

class LocationController extends ModuleController
{
    protected $moduleName = 'locations';

    /**
     * Relations to eager load for the index view
     */
    protected $indexWith = [];

    /**
     * Relations to eager load for the form view
     */
    protected $formWith = [];

    /**
     * Filters mapping ('filterName' => 'filterColumn')
     * In the indexData function, name your lists with the filter name + List (filterNameList)
     */
    protected $filters = [];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [];
    }
}

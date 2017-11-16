<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\SegmentRepository;

class CategoryController extends ModuleController
{
    protected $moduleName = 'categories';

    /*
     * Relations to eager load for the index view
     */
    protected $indexWith = [];

    /*
     * Relations to eager load for the form view
     */
    protected $formWith = ['segments'];

    /*
     * Filters mapping ('fFilterName' => 'filterColumn')
     * In the indexData function, name your lists with the filter name + List (fFilterNameList)
     */
    protected $filters = [];

    protected function formData($request)
    {
        return [
            'segmentsList' => app(SegmentRepository::class)->listAll('name'),
        ];
    }

    protected function indexData($request)
    {
        return [];
    }


}

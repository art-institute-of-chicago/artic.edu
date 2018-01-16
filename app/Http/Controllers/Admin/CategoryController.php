<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\SegmentRepository;

class CategoryController extends ModuleController
{
    protected $moduleName = 'categories';
    protected $modelName  = 'Api\Category';

    /*
     * Options of the index view
     */
    protected $defaultIndexOptions = [
        'create' => true,
        'publish' => false,
        'bulkPublish' => false,
        'feature' => false,
        'bulkFeature' => false,
        'restore' => false,
        'bulkRestore' => false,
        'bulkDelete' => false,
        'reorder' => false,
        'permalink' => false,
    ];

    // protected $titleColumnKey = 'name';

    // protected $indexColumns = [
    //     'name' => [
    //         'title' => 'Name',
    //         'edit_link' => true,
    //         'field' => 'name',
    //     ],
    // ];

    /*
     * Relations to eager load for the index view
     */
    protected $indexWith = [];

    /*
     * Relations to eager load for the form view
     */
    protected $formWith = ['segments'];

    // protected $defaultOrders = ['name' => 'ASC'];

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

    public function getIndexTableMainFilters($items)
    {
        return [];
    }
}

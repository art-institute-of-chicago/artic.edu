<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\SegmentRepository;

class SiteTagController extends ModuleController
{
    protected $moduleName = 'siteTags';

    protected $indexOptions = [
        'publish' => false,
    ];

    protected $titleColumnKey = 'name';

    protected $indexColumns = [
        'name' => [
            'title' => 'Name',
            'edit_link' => true,
            'field' => 'name',
        ],
    ];

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

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [
            'segmentsList' => app(SegmentRepository::class)->listAll('name'),
        ];
    }

}

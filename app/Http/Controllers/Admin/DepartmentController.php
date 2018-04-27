<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class DepartmentController extends BaseApiController
{
    protected $moduleName = 'departments';
    protected $hasAugmentedModel = true;

    protected $indexOptions = [
        'publish' => false,
        'bulkPublish' => false,
        'feature' => false,
        'bulkFeature' => false,
        'restore' => false,
        'create' => false,
        'delete' => false,
        'bulkRestore' => false,
        'bulkDelete' => false,
        'bulkEdit' => false,
        'reorder' => false,
        'permalink' => true,
    ];

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
        ],
        'augmented' => [
            'title' => 'Augmented?',
            'field' => 'augmented',
            'present' => true
        ]
    ];

}

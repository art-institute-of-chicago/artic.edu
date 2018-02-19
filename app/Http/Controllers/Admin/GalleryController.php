<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class GalleryController extends BaseApiController
{
    protected $moduleName = 'galleries';
    protected $hasAugmentedModel = false;

    protected $indexOptions = [
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

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
        ],
        'type' => [
            'title' => 'Type',
            'field' => 'type',
        ]
    ];

}

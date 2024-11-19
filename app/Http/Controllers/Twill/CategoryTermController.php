<?php

namespace App\Http\Controllers\Admin;

class CategoryTermController extends BaseApiController
{
    protected $moduleName = 'categoryTerms';
    protected $hasAugmentedModel = true;

    protected $indexOptions = [
        'create' => false,
        'edit' => false,
        'publish' => false,
        'bulkPublish' => false,
        'feature' => false,
        'bulkFeature' => false,
        'restore' => false,
        'bulkRestore' => false,
        'delete' => false,
        'bulkDelete' => false,
        'reorder' => false,
        'permalink' => false,
        'bulkEdit' => false,
        'editInModal' => false,
    ];

    protected $titleColumnKey = 'title';

    protected $indexColumns = [
        'image' => [
            'thumb' => true,
            'optional' => false,
            'variant' => [
                'role' => 'thumb',
                'crop' => 'default',
            ],
        ],
        'title' => [
            'title' => 'Title',
            'field' => 'title',
        ],
        'augmented' => [
            'title' => 'Augmented?',
            'field' => 'augmented',
            'present' => true
        ],
        'datahub_id' => [
            'title' => 'Datahub ID',
            'field' => 'id',
        ],
    ];

    protected $formWith = [];

    protected function indexData($request)
    {
        return [];
    }
}

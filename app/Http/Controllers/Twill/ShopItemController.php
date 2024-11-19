<?php

namespace App\Http\Controllers\Admin;

class ShopItemController extends BaseApiController
{
    protected $moduleName = 'shopItems';
    protected $hasAugmentedModel = false;

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
        'permalink' => false,
    ];

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
        ],
        'description' => [
            'title' => 'Description',
            'field' => 'description',
        ],
    ];
}

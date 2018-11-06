<?php

namespace App\Http\Controllers\Admin;

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
            'present' => true,
        ],
    ];

    protected function formData($request)
    {
        $item = $this->repository->getById(request('department') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/departments/' . $item->datahub_id . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }

}

<?php

namespace App\Http\Controllers\Admin;

class GalleryController extends BaseApiController
{
    protected $moduleName = 'galleries';
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
        $item = $this->repository->getById(request('gallery'));
        $baseUrl = '//'.config('app.url').'/galleries/'.$item->datahub_id.'/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }
}

<?php

namespace App\Http\Controllers\Admin;

class ArtistController extends BaseApiController
{
    protected $moduleName = 'artists';
    protected $hasAugmentedModel = true;

    protected $indexOptions = [
        'publish' => false,
        'bulkPublish' => false,
        'feature' => false,
        'bulkFeature' => false,
        'restore' => false,
        'bulkRestore' => false,
        'bulkDelete' => false,
        'reorder' => false,
        'permalink' => true,
    ];

    protected $titleColumnKey = 'title';

    protected $indexColumns = [
        'title' => [
            'title' => 'Name',
            'field' => 'title',
        ],
        'augmented' => [
            'title' => 'Augmented?',
            'field' => 'augmented',
            'present' => true,
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

    protected function formData($request)
    {
        $item = $this->repository->getById(request('artist') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/artists/' . $item->datahub_id . '/';

        return [
            'baseUrl' => $baseUrl,
        ];
    }
}

<?php

namespace App\Http\Controllers\Admin;
use App\Repositories\SiteTagRepository;

class ArtistController extends BaseApiController
{
    protected $moduleName = 'artists';
    protected $modelName  = 'Artist';
    protected $modelNameApi  = 'Api\Artist';
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
        'permalink' => false,
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
        ],
        'datahub_id' => [
            'title' => 'Datahub ID',
            'field' => 'datahub_id',
        ],
    ];

    protected $formWith = ['siteTags'];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [
            'siteTagsList' => app(SiteTagRepository::class)->listAll('name'),
        ];
    }

}

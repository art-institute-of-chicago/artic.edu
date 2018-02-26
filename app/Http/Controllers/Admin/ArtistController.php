<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SiteTagRepository;

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

<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\SiteTagRepository;

class ArtworkController extends BaseApiController
{
    protected $moduleName = 'artworks';
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
        'id' => [
            'title' => 'Datahub ID',
            'field' => 'id',
        ]
    ];

    /*
     * Relations to eager load for the form view
     */
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

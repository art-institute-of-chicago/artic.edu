<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\SiteTagRepository;

class ArtworkController extends BaseApiController
{
    protected $moduleName = 'artworks';
    protected $modelName  = 'Artwork';
    protected $modelNameApi  = 'Api\Artwork';
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

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'edit_link' => true,
            'field' => 'title',
        ],
        'augmented' => [
            'title' => 'Augmented?',
            'field' => 'augmented',
        ],
        'datahub_id' => [
            'title' => 'Datahub ID',
            'edit_link' => true,
            'field' => 'id',
        ],
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

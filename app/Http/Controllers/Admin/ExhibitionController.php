<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\SiteTagRepository;

class ExhibitionController extends ModuleController
{
    protected $moduleName = 'exhibitions';

    protected $indexOptions = [
        'feature' => true,
        'bulkFeature' => true,
    ];

    protected $indexColumns = [
        'image' => [
            'title' => 'Hero',
            'thumb' => true,
            'variant' => [
                'role' => 'hero',
                'crop' => 'square',
            ],
        ],
        'title' => [
            'title' => 'Title',
            'field' => 'title',
            'sort' => true,
        ],
        'lake_guid' => [
            'title' => 'lake_guid',
            'field' => 'lake_guid',
            'sort' => true,
        ],
        'startDate' => [
            'title' => 'Start date',
            'field' => 'startDate',
            'present' => true,
            'sort' => true,
            'sortKey' => 'start_date',
        ],
        'short_copy' => [
            'title' => 'Short copy',
            'field' => 'short_copy',
        ],
    ];

    protected $featureField = 'landing';

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'siteTags', 'shopItems'];

    protected $defaultFilters = ['search' => '%title'];

    protected $defaultOrders = ['start_date' => 'desc'];

    protected $filters = [];

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

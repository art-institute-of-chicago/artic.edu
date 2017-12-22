<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;
use App\Repositories\SiteTagRepository;

class EventController extends ModuleController
{
    protected $moduleName = 'events';

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
            'edit_link' => true,
            'sort' => true,
            'field' => 'title',
        ],
    ];

    protected $featureField = 'landing';

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'siteTags', 'events'];

    protected $filters = [];

    protected $defaultOrders = ['start_date' => 'desc'];

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

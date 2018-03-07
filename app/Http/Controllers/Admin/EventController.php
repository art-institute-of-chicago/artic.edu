<?php

namespace App\Http\Controllers\Admin;
use App\Repositories\SiteTagRepository;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class EventController extends ModuleController
{
    protected $moduleName = 'events';

    protected $indexOptions = [
        'publish' => true,
        'bulkPublish' => true,
    ];

    protected $indexColumns = [
        'title' => [
            'title' => 'Title',
            'field' => 'title',
        ]
    ];

    protected $featureField = 'landing';

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'siteTags', 'dateRules'];

    protected $filters = [];

    protected $defaultOrders = [];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [
            'siteTagsList' => app(SiteTagRepository::class)->listAll('name'),
            'eventTypesList' => $this->repository->getEventTypesList(),
            'eventAudiencesList' => $this->repository->getEventAudiencesList(),
            'eventLayoutsList' => $this->repository->getEventLayoutsList()
        ];
    }

}

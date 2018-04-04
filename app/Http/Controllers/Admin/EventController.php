<?php

namespace App\Http\Controllers\Admin;

use A17\CmsToolkit\Http\Controllers\Admin\ModuleController;

class EventController extends ModuleController
{
    protected $moduleName = 'events';
    protected $previewView = 'site.events.detail';

    protected $indexOptions = [
        'publish' => true,
        'bulkPublish' => true,
    ];

    protected $indexColumns = [
        'image' => [
            'thumb' => true,
            'optional' => false,
            'variant' => [
                'role' => 'hero',
                'crop' => 'default',
            ],
        ],
        'title' => [
            'title' => 'Title',
            'field' => 'title',
        ]
    ];

    protected $featureField = 'landing';

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'dateRules'];

    protected $filters = [];

    protected $defaultOrders = [];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        return [
            'eventTypesList' => $this->repository->getEventTypesList(),
            'eventAudiencesList' => $this->repository->getEventAudiencesList(),
            'eventLayoutsList' => $this->repository->getEventLayoutsList()
        ];
    }

}

<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\EventProgramRepository;

class EventController extends ModuleController
{
    protected $moduleName = 'events';
    protected $previewView = 'site.events.detail';

    protected $indexOptions = [
        'publish' => true,
        'bulkPublish' => true,
    ];

    protected $defaultOrders = [
        'publish_start_date' => 'desc',
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
        ],
        # The key must equal the field, else sortKey cannot be reached
        'presentPublishStartDate' => [
            'title' => 'Publish Date',
            'field' => 'presentPublishStartDate',
            'present' => true,
            'sort' => true,
            'sortKey' => 'publish_start_date',
        ],
    ];

    protected $featureField = 'landing';

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'dateRules'];

    protected $filters = [];

    protected function indexData($request)
    {
        return [];
    }

    protected function formData($request)
    {
        $item = $this->repository->getById(request('event') ?? request('id'));
        $baseUrl = '//' . config('app.url') . '/events/' . $item->id . '/';

        return [
            'eventTypesList' => $this->repository->getEventTypesList(),
            'eventAudiencesList' => $this->repository->getEventAudiencesList(),
            'eventLayoutsList' => $this->repository->getEventLayoutsList(),
            'eventProgramsList' => app(EventProgramRepository::class)->listAll('name'),
            'baseUrl' => $baseUrl,
        ];
    }

}

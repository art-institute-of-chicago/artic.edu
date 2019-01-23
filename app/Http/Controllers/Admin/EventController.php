<?php

namespace App\Http\Controllers\Admin;

use A17\Twill\Http\Controllers\Admin\ModuleController;
use App\Repositories\EventProgramRepository;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

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
        ],
    ];

    protected $featureField = 'landing';

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'dateRules'];

    protected $filters = [];

    protected $defaultOrders;

    public function __construct(Application $app, Request $request)
    {
        parent::__construct(...func_get_args());

        $this->indexColumns['formattedNextOcurrence'] = [
            'title' => 'Event Date',
            'field' => 'formattedNextOcurrence',
            'present' => true,
            'sort' => true,
            'sortKey' => null, // see getIndexItems()
        ];

        if ($this->getRequestFilters()['search'] ?? false) {
            $this->defaultOrders = ['_score' => 'desc'];
        } else {
            $this->defaultOrders = ['formattedNextOcurrence' => 'desc'];
        }
    }

    protected function getIndexItems($scopes = [], $forcePagination = false)
    {
        $sortKey = request('sortKey');

        if (isset($sortKey) && $sortKey !== 'formattedNextOcurrence')
        {
            return parent::getIndexItems($scopes, $forcePagination);
        }

        // Extracted from \A17\Twill\Repositories\ModuleRepository::get()
        $query = $this->repository->with($this->indexWith);
        $query = $this->repository->filter($query, $scopes);

        // We override the order call to use metas
        $query->orderBy(
            \DB::raw('(
               SELECT date
               FROM event_metas
               WHERE event_metas.event_id = events.id
               ORDER BY date
               LIMIT 1
            )'),
            request('sortDir') ?? 'desc'
        );

        // Forget about $forcePagination here
        return $query->paginate(request('offset') ?? $this->perPage ?? 50);
    }


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

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
        'duplicate' => true,
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
        'formattedNextOccurrence' => [
            'title' => 'Event Date',
            'field' => 'formattedNextOccurrence',
            'present' => true,
            'sort' => true,
        ]
    ];

    protected $featureField = 'landing';

    protected $indexWith = ['medias'];

    protected $formWith = ['revisions', 'dateRules'];

    protected $filters = [];

    protected $defaultOrders;

    /**
     * Twill has trouble ordering items by a column on related items.
     * We need to order `events` by their next occurrence (`event_metas`).
     * We will override the index function so it works the same in all
     * respects except item order.
     */
    protected function getIndexItems($scopes = [], $forcePagination = false)
    {
        $sortKey = request('sortKey');

        // Mitigate Twill bug with regards to `_page_offset` local storage
        if (!isset($sortKey)) {
            request()->merge([
                'sortKey' => 'formattedNextOccurrence',
                'sortDir' => 'desc',
            ]);
        }

        // This is a db search, not Elasticsearch search
        $filters = $this->getRequestFilters();

        if (is_array($filters) && ($filters['search'] ?? false)) {
            request()->merge([
                'sortKey' => null, // '_score',
                'sortDir' => null, // 'desc',
            ]);
        }

        if (request('sortKey') !== 'formattedNextOccurrence') {
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

        $autoRelated = collect($item->related($item->id))->unique('id')->filter();

        $featuredRelated = collect($item->getFeaturedRelated())->pluck('item');
        $featuredRelatedIds = $featuredRelated->pluck('id');

        // Remove featured related items from auto related items
        if ($featuredRelatedIds->isNotEmpty()) {
            $autoRelated = $autoRelated->reject(function ($relatedItem) use ($featuredRelatedIds) {
                return ($relatedItem !== null && ($featuredRelatedIds->contains($relatedItem->id) || $featuredRelatedIds->contains($relatedItem->datahub_id)));
            });
        }

        return [
            'autoRelated' => $autoRelated,
            'eventTypesList' => $this->repository->getEventTypesList(),
            'eventAudiencesList' => $this->repository->getEventAudiencesList(),
            'eventLayoutsList' => $this->repository->getEventLayoutsList(),
            'eventProgramsList' => app(EventProgramRepository::class)->listAll('name'),
            'eventAffiliateGroupsList' => app(EventProgramRepository::class)->affiliateGroups()->get()->pluck('name', 'id'),
            'eventHostsList' => app(EventProgramRepository::class)->eventHosts()->get()->pluck('name', 'id'),
            'eventEntrancesList' => $this->repository->getEventEntrancesList(),
            'baseUrl' => $baseUrl,
        ];
    }
}

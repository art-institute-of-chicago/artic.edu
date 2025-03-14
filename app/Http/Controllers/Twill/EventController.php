<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Presenter;
use A17\Twill\Services\Listings\TableColumns;
use App\Models\Event;
use App\Repositories\EventProgramRepository;
use Illuminate\Support\Facades\DB;

class EventController extends BaseController
{
    protected function setUpController(): void
    {
        $this->eagerLoadFormRelations(['revisions', 'dateRules']);
        $this->enableBulkFeature();
        $this->enableDuplicate();
        $this->enableFeature();
        $this->enableShowImage();
        $this->setFeatureField('landing');
        $this->setModuleName('events');
        $this->setPreviewView('site.events.detail');
        parent::setUpController();
    }

    protected function additionalIndexTableColumns(): TableColumns
    {
        $columns = new TableColumns();
        $columns->add(
            Presenter::make()
                ->field('formattedNextOccurrence')
                ->title('Event Date')
                ->sortable()
        );

        return $columns;
    }

    /**
     * Twill has trouble ordering items by a column on related items.
     * We need to order `events` by their next occurrence (`event_metas`).
     * We will override the index function so it works the same in all
     * respects except item order.
     */
    protected function getIndexItems(array $scopes = [], bool $forcePagination = false)
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
            DB::raw('(
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
        $baseUrl = config('app.url') . '/events/' . $item->id . '/';

        return [
            'autoRelated' => $this->getAutoRelated($item),
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

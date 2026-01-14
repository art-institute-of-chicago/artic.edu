<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Services\Listings\Columns\Presenter;
use A17\Twill\Services\Listings\TableColumns;
use App\Repositories\EventProgramRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

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
    protected function orderScope(): array
    {
        $orders = [];

        if ($this->request->has('sortKey') && $this->request->has('sortDir')) {
            if ($this->request->get('sortKey') === 'formattedNextOccurrence') {
                $orders['formattedNextOccurrence'] = [
                    'callback' => function (Builder $builder, string $direction) {
                        return $builder->orderBy(DB::raw('(
                            SELECT date
                            FROM event_metas
                            WHERE event_metas.event_id = events.id
                            ORDER BY date
                            LIMIT 1
                        )'));
                    },
                    'direction' => $this->request->get('sortDir') ?? 'desc',
                ];
            }
        }

        return $orders + parent::orderScope();
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

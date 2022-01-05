<?php

namespace App\Repositories\Api;

use App\Models\Api\TicketedEventType;
use App\Models\Api\Search;

class TicketedEventTypeRepository extends BaseApiRepository
{
    const TICKETED_EVENT_TYPES_PER_PAGE = 100;

    public function __construct(TicketedEventType $model)
    {
        $this->model = $model;
    }

    public function getTicketedEventTypesCollection($item)
    {
        return Search::query()
            ->resources(['ticketed-event-types'])
            ->byIds([$item->datahub_id])
            ->getSearch(self::TICKETED_EVENT_TYPES_PER_PAGE);
    }
}

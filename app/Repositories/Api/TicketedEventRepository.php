<?php

namespace App\Repositories\Api;

use App\Models\Api\TicketedEvent;
use App\Models\Api\Search;

class TicketedEventRepository extends BaseApiRepository
{
    const TICKETED_EVENTS_PER_PAGE = 20;

    public function __construct(TicketedEvent $model)
    {
        $this->model = $model;
    }

    public function getTicketedEventsCollection($item)
    {
        return Search::query()
            ->resources(['ticketed-events'])
            ->byIds([$item->datahub_id])
            ->getSearch(self::TICKETED_EVENTS_PER_PAGE);
    }
}

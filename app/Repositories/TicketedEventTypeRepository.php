<?php

namespace App\Repositories;

use App\Models\TicketedEventType;
use App\Repositories\Behaviors\HandleApiBlocks;

class TicketedEventTypeRepository extends ModuleRepository
{
    use HandleApiBlocks;

    public function __construct(TicketedEventType $model)
    {
        $this->model = $model;
    }
}

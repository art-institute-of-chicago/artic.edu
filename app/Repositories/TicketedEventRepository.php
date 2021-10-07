<?php

namespace App\Repositories;

use App\Models\TicketedEvent;
use App\Repositories\Behaviors\HandleApiBlocks;

class TicketedEventRepository extends ModuleRepository
{
    use HandleApiBlocks;

    public function __construct(TicketedEvent $model)
    {
        $this->model = $model;
    }
}

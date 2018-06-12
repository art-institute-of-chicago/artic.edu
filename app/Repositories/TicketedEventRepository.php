<?php

namespace App\Repositories;

use A17\Twill\Repositories\ModuleRepository;
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

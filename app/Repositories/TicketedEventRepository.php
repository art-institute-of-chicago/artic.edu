<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\TicketedEvent;
use App\Repositories\Behaviors\HandleApiBlocks;

class TicketedEventRepository extends ModuleRepository
{

    use HandleApiBlocks;

    public function __construct(TicketedEvent $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {

        $this->updateBrowserApiRelated($object, $fields, ['ticketedEvent']);

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['ticketedEvents'] = $this->getFormFieldsForBrowserApi($object, 'ticketedEvent', 'App\Models\Api\TicketedEvent', 'exhibitions_events');

        return $fields;
    }

}

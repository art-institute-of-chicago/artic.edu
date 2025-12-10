<?php

namespace App\Http\Controllers\Twill;

class TicketedEventController extends \App\Http\Controllers\Twill\BaseApiController
{
    public function setUpController(): void
    {
        $this->setTitleColumnKey('cmsTitle');
        $this->setSearchColumns(['name', 'id']);
        $this->setModuleName('ticketedEvents');
    }
}

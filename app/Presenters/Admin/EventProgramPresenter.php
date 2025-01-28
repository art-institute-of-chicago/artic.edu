<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class EventProgramPresenter extends BasePresenter
{
    public function isAffiliateGroup()
    {
        return $this->entity->is_affiliate_group ? 'Yes' : 'No';
    }

    public function isEventHost()
    {
        return $this->entity->is_event_host ? 'Yes' : 'No';
    }
}

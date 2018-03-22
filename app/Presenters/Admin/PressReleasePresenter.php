<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;
use App\Models\PressRelease;
use Carbon\Carbon;

class PressReleasePresenter extends BasePresenter
{

    public function presentPublishStartDate() {
        if ($this->entity->publish_start_date) {
            if (!empty($this->entity->publish_start_date)) {
                return $this->entity->publish_start_date->format('m d Y');
            }
        }

        return "No";
    }

}

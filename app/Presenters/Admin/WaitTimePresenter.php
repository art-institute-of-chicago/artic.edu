<?php

// This has been moved from the model and should be completely refactored
//
// Blocks building are specially overcomplicated.

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;
use Illuminate\Support\Str;

class WaitTimePresenter extends BasePresenter
{
    public function display() {
        return $this->entity->duration . ' ' . Str::plural($this->units, $this->entity->duration);
    }

    public function units() {
        switch ($this->entity->units) {
            case 'ms':   return 'millisecond';
            case 'sec':  return 'second';
            case 'min':  return 'minute';
            case 'hrs':  return 'hour';
            case 'days': return 'day';
        }
    }

}

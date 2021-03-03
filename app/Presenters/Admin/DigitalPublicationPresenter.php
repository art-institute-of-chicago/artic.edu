<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class DigitalPublicationPresenter extends BasePresenter
{
    private $sections = [];

    public function date()
    {
        if ($this->entity->date) {
            return $this->entity->date->format('M j, Y');
        }
    }

    public function hasSections($type = null)
    {
        return $this->getSections($type)->count() > 0;
    }

    public function getSections($type = null)
    {
        if (!isset($this->sections['all'])) {
            $this->sections['all'] = $this->entity
                ->sections()
                ->published()
                ->get();
        }

        if (!isset($type)) {
            return $this->sections['all'];
        }

        if (!isset($this->sections[$type])) {
            $this->sections[$type] = $this->sections['all']
                ->filter(function($section) use ($type) {
                    return $section->type === $type;
                })
                ->values();
        }

        return $this->sections[$type];
    }

    protected function isDscStub()
    {
        return $this->entity->is_dsc_stub ? 'Yes' : 'No';
    }
}

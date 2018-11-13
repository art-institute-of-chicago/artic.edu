<?php

namespace App\Libraries\Search\Filters;

class DateRange
{
    public function generate()
    {
        $base = [
            'title'   => 'Date',
            'type'    => 'date',
            'active'  => false,
            'enabled' => false
        ];

        if (request()->filled('date-start') || request()->filled('date-end')) {
            $base['href']  = route('collection', request()->except(['page', 'date-start', 'date-end']));
            $base['label'] = $this->generateLabel();
            $base['active'] = true;
            $base['enabled'] = true;
        }

        return $base;
    }

    protected function generateLabel()
    {
        return join('–', [preg_replace('/(AD|BC)/i', ' $1', request()->get('date-start')), preg_replace('/(AD|BC)/i', ' $1', request()->get('date-end'))]);
    }

}

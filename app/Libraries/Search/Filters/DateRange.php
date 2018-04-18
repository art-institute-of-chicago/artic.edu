<?php

namespace App\Libraries\Search\Filters;

class DateRange
{
    public function generate()
    {
        $base = [
            'title'       => 'Date',
            'type'        => 'date',
            'active'      => true,
        ];

        if (request()->filled('date-start') || request()->filled('date-end')) {
            $base['href']  = route('collection', request()->except(['date-start', 'date-end']));
            $base['label'] = $this->generateLabel();
            $base['enabled'] = true;
        } else {
            $base['enabled'] = false;
        }

        return $base;
    }

    protected function generateLabel()
    {
        return join(' - ', [request()->get('date-start'), request()->get('date-end')]);
    }

}

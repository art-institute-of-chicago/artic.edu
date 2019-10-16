<?php

namespace App\Libraries\Search\Filters;

class Deaccessions
{
    protected $parameter  = 'is_deaccessioned';

    public function generate()
    {
        return !request()->input($this->parameter) ? [] : [
            [
                'href' => route('collection', request()->except(['page', $this->parameter])),
                'label' => 'Deaccessioned',
            ]
        ];
    }
}

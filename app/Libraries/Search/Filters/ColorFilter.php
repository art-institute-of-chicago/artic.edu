<?php

namespace App\Libraries\Search\Filters;

class ColorFilter
{
    public function generate()
    {
        if (request()->filled('color')) {
            return [[
                'title'   => 'Color',
                'type'    => 'color',
                'href'    => route('collection', request()->except(['page', 'color'])),
                'label'   => $this->generateLabel(),
            ]];
        }

        return [];
    }

    protected function generateLabel()
    {
        return "Color";
    }

}

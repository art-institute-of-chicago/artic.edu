<?php

namespace App\Libraries\Search\Filters;

class BooleanFilter
{
    // Define parameter and label to be processed
    protected $options = [];

    public function __construct($possibleOptions)
    {
        $this->options = collect($possibleOptions);
    }

    public function generate()
    {
        $base = [
            'type'   => 'list',
            'title'  => 'Show Only',
            'active' => true,
            'collapsible' => false,
            'list' => $this->generateOptionsList()
        ];

        return $base;
    }

    protected function generateOptionsList()
    {
        return collect($this->options)->map(function($label, $item) {
            $base = [
                'enabled' => false,
                'label'   => $label,
                'disableCount' => true, //Disable count as we have no facets here
            ];

            // If parameter is present, means that it's checked, create a route to remove it
            if (request()->filled($item)) {
                $base['href'] = route('collection', request()->except(['page', $item]));
                $base['enabled'] = true;
            } else {
                $base['href'] = route('collection', request()->except(['page']) + [$item => true]);
            }

            return $base;
        })->values();
    }

}

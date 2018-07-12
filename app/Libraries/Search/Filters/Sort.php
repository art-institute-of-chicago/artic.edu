<?php

namespace App\Libraries\Search\Filters;

class Sort
{
    protected $activeList = false;
    protected $parameter  = 'sort_by';

    protected $options;

    public function __construct($possibleOptions)
    {
        $this->options = collect($possibleOptions);
    }

    public function generate()
    {
        $list = $this->generateSortFilters();

        if (!$list->isEmpty()) {
            return [
                'list'        => $list,
                'title'       => 'Sort',
                'active'      => $this->activeList,
                'type'        => 'dropdown',
                'collapsible' => true,
            ];
        }
    }

    public function generateSortFilters()
    {
        $list = $this->options->map(function ($option) {
            // Isolate the parameter
            $input = collect(request()->only($this->parameter));

            // If input contains the parameter, set the list as active
            if ($input->has($this->parameter) && $enabled = $input->contains($option)) {
                $this->activeList = true;
                $route = route('collection', request()->except(['page', $this->parameter]));
            } else {
                $route = route('collection', request()->except(['page', $this->parameter]) + [$this->parameter => $option]);
            }

            return [
                'href'    => $route,
                'label'   => 'By ' . $this->generateLabel($option),
                'enabled' => $enabled ?? false
            ];
        });

        return $list;
    }

    protected function generateLabel($parameter)
    {
        switch ($parameter) {
            case 'date_start':
                return 'Date';
            case 'artist_title':
                return 'Artist';
            default:
                return str_replace('_', ' ', title_case($parameter));
        }
    }

}

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
                'title'       => 'Sort By',
                'active'      => $this->activeList,
                'type'        => 'dropdown',
                'collapsible' => false,
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
                $route = route('collection', request()->except($this->parameter));
            } else {
                $route = route('collection', [$this->parameter => $option]);
            }

            return [
                'href'    => $route,
                'label'   => ucfirst($option),
                'enabled' => $enabled ?? false
            ];
        })->sortByDesc('enabled');

        return $list;
    }

}

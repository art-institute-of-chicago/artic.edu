<?php

namespace App\Libraries\Search\Filters;

class Themes
{
    protected $parameter = 'theme_ids';
    protected $entity = \App\Models\Api\Category::class;

    /**
     * Basic functionality to get currently active hidden filters to build
     * buttons to remove them when searching.
     */
    public function generate()
    {
        $list = [];
        $input = collect(explode(';', request()->input($this->parameter)))->filter();

        foreach ($input as $element) {
            $newInput = $input->forget($input->search($element))->filter();
            $extraParams = $newInput->isEmpty() ? [] : [$this->parameter => join(',', $newInput->toArray())];
            // Build the checkbox route using previously calculated inputs
            $route = route('collection', request()->except(['page', $this->parameter]) + $extraParams);

            $list[] = [
                'href' => $route,
                'label' => $this->findLabel($element)
            ];
        }

        return $list;
    }

    public function findLabel($id)
    {
        // The active value may be a plain title (not an id); return it as-is
        // instead of performing a database call for a value that isn't findable.
        if (!is_numeric($id)) {
            return $id;
        }

        try {
            $label = $this->entity::query()->find($id);

            return $label ? $label->title : $id;
        } catch (\Throwable $e) {
            // The lookup failed; fall back to the original value.
            return $id;
        }
    }
}

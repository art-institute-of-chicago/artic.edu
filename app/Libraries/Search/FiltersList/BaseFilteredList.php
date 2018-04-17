<?php

namespace App\Libraries\Search\FiltersList;

class BaseFilteredList
{
    protected $buckets;
    protected $parameter;

    protected $activeList = false;

    public function generateFilteredCategory()
    {
        // Build options list and sort by selected (move selected at the beginning)
        $list = $this->buckets->map(function ($item) {
            // Get all ID's for the category
            $input = collect(explode(',', request()->input($this->parameter)));

            // If input contains the ID, remove it from the URL (uncheck link)
            if ($enabled = $input->contains($item->key)) {
                // If there's any selected element open the tab by default
                $this->activeList = true;
                $newInput = $input->forget($input->search($item->key))->filter();
            } else {
                $newInput = $input->push($item->key)->filter();
            }

            // Build the checkbox route using previously calculated inputs
            $route = route('collection', request()->except($this->parameter) + [$this->parameter => join(',', $newInput->toArray())]);

            return [
                'href' => $route,
                'count' => $item->doc_count,
                'label' => $item->key,
                'enabled' => $enabled
            ];
        })->sortByDesc('enabled'); // Move selected ones to the timezone_open()

        return $list;
    }
}

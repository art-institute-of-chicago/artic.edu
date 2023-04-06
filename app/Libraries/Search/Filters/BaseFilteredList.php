<?php

namespace App\Libraries\Search\Filters;

class BaseFilteredList
{
    protected $buckets;
    protected $labels;
    protected $entity;

    protected $parameter;

    protected $activeList = false;

    protected $aggregationName;

    public function __construct($buckets, $aggregationName)
    {
        $this->buckets = collect($buckets);
        $this->aggregationName = $aggregationName;
    }

    public function generateFilteredCategory()
    {
        // Get all ID's for the category
        $inputs = request()->input($this->parameter);
        $inputs = collect($inputs ? explode(';', $inputs) : []);

        // WEB-1035: If there's no item with a requested id in buckets, prepend it
        foreach ($inputs as $input) {
            if (
                !$this->buckets->contains(function ($item) use ($input) {
                    return $item->key === $input;
                })
            ) {
                $this->buckets->prepend((object) [
                    'key' => $input,
                    'doc_count' => 'N/A',
                ]);
            }
        }

        // Build options list and sort by selected (move selected at the beginning)
        $list = $this->buckets->map(function ($item) use ($inputs) {
            // Start afresh so we aren't modifying the same collection each time
            $inputs = clone $inputs;

            // If input contains the ID, remove it from the URL (uncheck link)
            if ($enabled = $inputs->contains($item->key)) {
                // If there's any selected element open the tab by default
                $this->activeList = true;
                $newInput = $inputs->forget($inputs->search($item->key))->filter();
            } else {
                $newInput = $inputs->push($item->key)->filter();
            }

            $extraParams = $newInput->isEmpty() ? [] : [$this->parameter => join(';', $newInput->toArray())];

            // Build the checkbox route using previously calculated inputs
            $route = route('collection', request()->except(['page', $this->parameter, 'categoryQuery']) + $extraParams);

            return [
                'href' => $route,
                'count' => $item->doc_count,
                'label' => $this->findLabel($item->key),
                'enabled' => $enabled
            ];
        })->sortByDesc('count');

        return $list;
    }

    public function findLabel($id)
    {
        $label = $this->loadLabels()->get($id);

        return ucfirst($label);
    }

    public function loadLabels()
    {
        if ($this->labels) {
            return $this->labels;
        }

        // Get ID's from buckets
        $ids = $this->buckets->pluck('key')->toArray();

        // Load entities and build an array with ID => Title
        $this->labels = $this->entity::query()
            ->ids($ids)
            ->get(['id', 'title'])
            ->pluck('title', 'id');

        return $this->labels;
    }
}

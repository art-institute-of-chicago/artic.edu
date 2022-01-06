<?php

namespace App\Libraries\Search\Filters;

class Artists extends BaseFilteredList
{
    protected $parameter = 'artist_ids';
    protected $entity = \App\Models\Api\Artist::class;

    public function generate()
    {
        $list = $this->generateFilteredCategory();

        if (!$list->isEmpty()) {
            return [
                'placeholder' => 'Find Artists',
                'title' => 'Artists',
                'active' => $this->activeList,
                'list' => $list,
                'listSearch' => true,
                'type' => 'list',
                'aggregation' => $this->aggregationName,
                'listSearchUrl' => route('collection.categorySearch', request()->except(['categoryName', 'categoryQuery']) + ['categoryName' => 'artists'])
            ];
        }
    }

    public function findLabel($key)
    {
        return ucfirst($key);
    }
}

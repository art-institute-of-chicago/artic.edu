<?php

namespace App\Libraries\Search\Filters;

class ArtworkType extends BaseFilteredList
{
    protected $parameter = 'artwork_type_id';
    protected $entity = \App\Models\Api\ArtworkType::class;

    public function generate()
    {
        $list = $this->generateFilteredCategory();

        if (!$list->isEmpty()) {
            return [
                'placeholder' => 'Find Artwork Types',
                'title' => 'Artwork Type',
                'active' => $this->activeList,
                'list' => $list,
                'listSearch' => true,
                'type' => 'list',
                'aggregation' => $this->aggregationName,
                'listSearchUrl' => route('collection.categorySearch', request()->except(['categoryQuery']) + ['categoryName' => 'artwork_type'])
            ];
        }
    }

    public function findLabel($key)
    {
        return ucfirst($key);
    }
}

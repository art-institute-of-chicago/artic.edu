<?php

namespace App\Libraries\Search\Filters;

class Classifications extends BaseFilteredList
{
    protected $parameter  = 'classification_ids';
    protected $entity     = \App\Models\Api\CategoryTerm::class;

    public function generate()
    {
        $list = $this->generateFilteredCategory();

        if (!$list->isEmpty()) {
            return [
                'placeholder' => "Find Classifications",
                'title'       => "Classifications",
                'active'      => $this->activeList,
                'list'        => $list,
                'listSearch'  => true,
                'type'        => 'list',
                'aggregation' => $this->aggregationName,
                'listSearchUrl' => route('collection.categorySearch', request()->except(['categoryQuery']) + ['categoryName' => 'classifications'])
            ];
        }
    }

    public function findLabel($key)
    {
        return ucfirst($key);
    }

}

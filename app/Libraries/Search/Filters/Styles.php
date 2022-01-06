<?php

namespace App\Libraries\Search\Filters;

class Styles extends BaseFilteredList
{
    protected $parameter = 'style_ids';
    protected $entity = \App\Models\Api\CategoryTerm::class;

    public function generate()
    {
        $list = $this->generateFilteredCategory();

        if (!$list->isEmpty()) {
            return [
                'placeholder' => 'Find Styles',
                'title' => 'Styles',
                'active' => $this->activeList,
                'list' => $list,
                'listSearch' => true,
                'type' => 'list',
                'aggregation' => $this->aggregationName,
                'listSearchUrl' => route('collection.categorySearch', request()->except(['categoryQuery']) + ['categoryName' => 'styles'])
            ];
        }
    }

    public function findLabel($key)
    {
        return ucfirst($key);
    }
}

<?php

namespace App\Libraries\Search\Filters;

class Places extends BaseFilteredList
{
    protected $parameter  = 'place_ids';
    protected $entity     = \App\Models\Api\Place::class;

    public function generate()
    {
        $list = $this->generateFilteredCategory();

        if (!$list->isEmpty()) {
            return [
                'placeholder' => "Find Places",
                'title'       => "Places",
                'active'      => $this->activeList,
                'list'        => $list,
                'listSearch'  => true,
                'type'        => 'list',
                'aggregation' => $this->aggregationName,
                'listSearchUrl' => route('collection.categorySearch', request()->input() + ['categoryName' => 'places'])
            ];
        }
    }

    public function findLabel($id)
    {
        return ucfirst($id);
    }

}

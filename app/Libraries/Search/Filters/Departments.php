<?php

namespace App\Libraries\Search\Filters;

class Departments extends BaseFilteredList
{
    protected $parameter  = 'department_ids';
    protected $entity     = \App\Models\Api\Department::class;

    public function generate()
    {
        $list = $this->generateFilteredCategory();

        if (!$list->isEmpty()) {
            return [
                'placeholder' => "Find Departments",
                'title'       => "Departments",
                'active'      => $this->activeList,
                'list'        => $list,
                'listSearch'  => true,
                'type'        => 'list',
                'aggregation' => $this->aggregationName,
                'listSearchUrl' => route('collection.categorySearch', request()->except(['categoryQuery']) + ['categoryName' => 'departments'])
            ];
        }
    }

    public function findLabel($key)
    {
        return ucfirst($key);
    }

}

<?php

namespace App\Libraries\Search\Filters;

class Departments extends BaseFilteredList
{
    protected $parameter  = 'department_ids';
    protected $entity     = \App\Models\Api\Category::class;

    public function __construct($buckets)
    {
        $this->buckets = collect($buckets);
    }

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
                'listSearchUrl' => '#'
            ];
        }
    }

}

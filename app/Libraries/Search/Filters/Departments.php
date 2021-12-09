<?php

namespace App\Libraries\Search\Filters;

class Departments extends BaseFilteredList
{
    protected $parameter  = 'department_ids';
    protected $entity     = \App\Models\Api\Department::class;

    private $hiddenDepartments = [
        'PC-826' => 'AIC Archives',
        'PC-824' => 'Ryerson and Burnham Libraries Special Collections',
    ];

    public function generate()
    {
        $list = $this->generateFilteredCategory();

        $sortedDepartments = $list->pluck('label')->sort()->diff($this->hiddenDepartments)->values();

        $sortedList = $sortedDepartments->map(function ($title) use ($list) {
            return $list->firstWhere('label', $title);
        })->filter();

        if (!$list->isEmpty()) {
            return [
                'placeholder' => "Find Departments",
                'title'       => "Departments",
                'active'      => $this->activeList,
                'list'        => $sortedList,
                'listSearch'  => false,
                'showMore'    => false,
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

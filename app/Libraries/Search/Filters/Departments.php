<?php

namespace App\Libraries\Search\Filters;

class Departments extends BaseFilteredList
{
    protected $parameter  = 'department_ids';
    protected $entity     = \App\Models\Api\Department::class;

    private $departments = [
        'PC‌-2' => 'American Art',
        'PC‌-4' => 'Ancient and Byzantine Art',
        'PC‌-5' => 'Architecture and Design',
        'PC‌-6' => 'Arms, Armor, Medieval, and Renaissance',
        'PC‌-1' => 'Arts of Africa',
        'PC‌-3' => 'Arts of the Americas',
        'PC‌-7' => 'Asian Art',
        'PC‌-8' => 'Contemporary Art',
        'PC‌-9' => 'European Decorative Art',
        'PC‌-10' => 'European Painting and Sculpture',
        'PC‌-11' => 'Modern Art',
        'PC‌-12' => 'Photography',
        'PC‌-13' => 'Prints and Drawings',
        'PC‌-14' => 'Textiles',
        'PC‌-15' => 'Thorne Miniature Rooms',
    ];

    public function generate()
    {
        $list = $this->generateFilteredCategory();

        $list = collect($this->departments)->values()->map(function($title) use ($list) {
            return $list->firstWhere('label', $title);
        })->filter();

        if (!$list->isEmpty()) {
            return [
                'placeholder' => "Find Departments",
                'title'       => "Departments",
                'active'      => $this->activeList,
                'list'        => $list,
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

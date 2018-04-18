<?php

namespace App\Libraries\Search\Filters;

class Subjects extends BaseFilteredList
{
    protected $parameter  = 'subject_ids';
    protected $entity     = \App\Models\Api\CategoryTerm::class;

    public function __construct($buckets)
    {
        $this->buckets = collect($buckets);
    }

    public function generate()
    {
        $list = $this->generateFilteredCategory();

        if (!$list->isEmpty()) {
            return [
                'placeholder' => "Find Subjects",
                'title'       => "Subjects",
                'active'      => $this->activeList,
                'list'        => $list,
                'listSearch'  => true,
                'type'        => 'list',
            ];
        }
    }

}

<?php

namespace App\Libraries\Search\Filters;

class Materials extends BaseFilteredList
{
    protected $parameter  = 'material_ids';
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
                'placeholder' => "Find Materials",
                'title'       => "Materials",
                'active'      => $this->activeList,
                'list'        => $list,
                'listSearch'  => true,
                'type'        => 'list',
                'listSearchUrl' => '#'
            ];
        }
    }

}

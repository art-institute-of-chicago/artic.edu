<?php

namespace App\Libraries\Search\Filters;

class Styles extends BaseFilteredList
{
    protected $parameter  = 'style_ids';

    public function __construct($buckets)
    {
        $this->buckets = collect($buckets);
    }

    public function generate()
    {
        $list = $this->generateFilteredCategory();

        if (!$list->isEmpty()) {
            return [
                'placeholder' => "Find Styles",
                'title'       => "Styles",
                'active'      => $this->activeList,
                'list'        => $list,
                'listSearch'  => true,
                'type'        => 'list',
            ];
        }
    }

}

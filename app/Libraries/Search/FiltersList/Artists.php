<?php

namespace App\Libraries\Search\FiltersList;

class Artists extends BaseFilteredList
{
    protected $parameter  = 'artist_ids';

    public function __construct($buckets)
    {
        $this->buckets = collect($buckets);
    }

    public function generate()
    {
        $list = $this->generateFilteredCategory();

        if (!$list->isEmpty()) {
            return [
                'placeholder' => "Find Artists",
                'title'       => "Artists",
                'active'      => $this->activeList,
                'list'        => $list,
                'listSearch'  => true,
                'type'        => 'list',
            ];
        }
    }

}

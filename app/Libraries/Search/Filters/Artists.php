<?php

namespace App\Libraries\Search\Filters;

class Artists extends BaseFilteredList
{
    protected $parameter  = 'artist_ids';
    protected $entity     = \App\Models\Api\Artist::class;

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

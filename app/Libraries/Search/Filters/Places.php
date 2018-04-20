<?php

namespace App\Libraries\Search\Filters;

class Places extends BaseFilteredList
{
    protected $parameter  = 'place_ids';
    protected $entity     = \App\Models\Api\Place::class;

    public function __construct($buckets)
    {
        $this->buckets = collect($buckets);
    }

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
                'listSearchUrl' => '#'
            ];
        }
    }

    public function findLabel($id)
    {
        return ucfirst($id);
    }

}

<?php

namespace App\Http\Controllers\API;

class HoursController extends BaseController
{
    protected $model = \App\Models\Hour::class;
    protected $transformer = \App\Http\Transformers\HourTransformer::class;

    /**
     * Only include currently active hours
     *
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginate($limit)
    {
        return ($this->model)::today()->limit(1)->paginate($limit);
    }
}

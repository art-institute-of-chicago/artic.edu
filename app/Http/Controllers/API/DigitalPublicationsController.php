<?php

namespace App\Http\Controllers\API;

class DigitalPublicationsController extends BaseController
{
    protected $model = \App\Models\DigitalPublication::class;
    protected $transformer = \App\Http\Transformers\DigitalPublicationTransformer::class;

    /**
     * Exclude unlisted digital publications.
     *
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginate($limit)
    {
        return ($this->model)::notUnlisted()->paginate($limit);
    }
}

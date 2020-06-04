<?php

namespace App\Http\Controllers\API;

class ExperiencesController extends BaseController
{
    protected $model = \App\Models\Experience::class;
    protected $transformer = \App\Http\Transformers\ExperienceTransformer::class;

    public function validateId($id)
    {
        return true;
    }

    /**
     * Exclude unlisted experiences.
     *
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginate($limit)
    {
        return ($this->model)::listed()->orderBy('updated_at', 'desc')->paginate($limit);
    }
}

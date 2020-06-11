<?php

namespace App\Http\Controllers\API;

class SelectionsController extends BaseController
{
    protected $model = \App\Models\Selection::class;
    protected $transformer = \App\Http\Transformers\SelectionTransformer::class;

    public function validateId($id)
    {
        return true;
    }

    /**
     * Exclude unlisted highlights.
     *
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginate($limit)
    {
        return ($this->model)::listed()->orderBy('updated_at', 'desc')->paginate($limit);
    }

}

<?php

namespace App\Http\Controllers\API;

class GenericPagesController extends BaseController
{
    protected $model = \App\Models\GenericPage::class;
    protected $transformer = \App\Http\Transformers\GenericPageTransformer::class;

    public function validateId($id)
    {
        return true;
    }

    /**
     * Exclude any pages with `redirect_url` set.
     *
     * @param mixed $ids
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function find($ids)
    {
        return ($this->model)::whereNull('redirect_url')->find($ids);
    }

    /**
     * Exclude any pages with `redirect_url` set.
     *
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginate($limit)
    {
        return ($this->model)::whereNull('redirect_url')->orderBy('updated_at', 'desc')->paginate($limit);
    }
}

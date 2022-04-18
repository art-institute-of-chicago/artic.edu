<?php

namespace App\Http\Controllers\API;

class PressReleasesController extends BaseController
{
    protected $model = \App\Models\PressRelease::class;
    protected $transformer = \App\Http\Transformers\PressReleaseTransformer::class;


    /**
     * Exclude unlisted experiences.
     *
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginate($limit)
    {
        return ($this->model)::notUnlisted()->orderBy('updated_at', 'desc')->paginate($limit);
    }
}

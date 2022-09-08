<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\Behaviors\HideUnlisted;

class PressReleasesController extends BaseController
{
    use HideUnlisted;

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
        return ($this->model)::orderBy('updated_at', 'desc')->paginate($limit);
    }
}

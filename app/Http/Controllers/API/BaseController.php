<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Aic\Hub\Foundation\AbstractController;

class BaseController extends AbstractController
{
    /**
     * Call to get a model list. Override this method when logic to get
     * models is more complex than a simple `$model::paginate($limit)` call.
     *
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginateTrashed($limit)
    {
        return ($this->model)::onlyTrashed()->paginate($limit);
    }
}

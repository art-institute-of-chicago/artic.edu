<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Aic\Hub\Foundation\AbstractController;

class BaseController extends AbstractController
{
    /**
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginateTrashed($limit)
    {
        return ($this->model)::onlyTrashed()->paginate($limit);
    }

    /**
     * API-331: Remove unpublished items from the API
     */
    protected function getBaseQuery()
    {
        return parent::getBaseQuery()->published();
    }
}

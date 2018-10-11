<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Aic\Hub\Foundation\AbstractController;

class BaseController extends AbstractController
{

    /**
     * Display a listing of the deleted resources.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleted(Request $request)
    {

        return $this->collect( $request, function( $limit ) {

            return $this->paginateTrashed( $limit );

        });

    }

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

    /**
     * Call to get a model list. Override this method when logic to get
     * models is more complex than a simple `$model::paginate($limit)` call.
     *
     * @param int $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected function paginate($limit)
    {

        return ($this->model)::orderBy('updated_at', 'desc')->paginate($limit);

    }
}
